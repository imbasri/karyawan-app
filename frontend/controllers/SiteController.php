<?php

namespace frontend\controllers;

use frontend\models\Biodata;
use frontend\models\Pekerjaan;
use frontend\models\Pelatihan;
use frontend\models\Pendidikan;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\base\Model;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    private function createMultiple($modelClass, $multipleModels = [])
    {
        $model = new $modelClass;
        $formName = $model->formName();
        $post = Yii::$app->request->post($formName);
        $models = [];

        if ($post && is_array($post)) {
            foreach ($post as $item) {
                $newModel = new $modelClass;
                $newModel->setAttributes($item);
                $models[] = $newModel;
            }
            return $models;
        }

        return $multipleModels;
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    /**
     * Displays mydata page.
     *
     * @return mixed
     */
    public function actionMydata()
    {
        $biodata = new Biodata();
        $pendidikan = new Pendidikan();
        $pekerjaan = new Pekerjaan();
        $pelatihan = new Pelatihan();

        // Get existing biodata for the current user
        $existingBiodata = Biodata::findOne(['user_id' => Yii::$app->user->id]);
        if ($existingBiodata) {
            $biodata = $existingBiodata;
            $pendidikanModels = Pendidikan::findAll(['biodata_id' => $biodata->id]) ?: [new Pendidikan()];
            $pekerjaanModels = Pekerjaan::findAll(['biodata_id' => $biodata->id]) ?: [new Pekerjaan()];
            $pelatihanModels = Pelatihan::findAll([
                'biodata_id' => $biodata->id
            ]) ?: [new Pelatihan()];
        } else {
            // Handle multiple models for pendidikan, pekerjaan, and pelatihan
            $pendidikanModels = [new Pendidikan()];
            $pekerjaanModels = [new Pekerjaan()];
            $pelatihanModels = [new Pelatihan()];
        }

        if ($biodata->load(Yii::$app->request->post())) {

            // Load and validate multiple models
            $pendidikanModels = $this->createMultiple(Pendidikan::class);
            Model::loadMultiple($pendidikanModels, Yii::$app->request->post());

            $pekerjaanModels = $this->createMultiple(Pekerjaan::class);
            Model::loadMultiple($pekerjaanModels, Yii::$app->request->post());

            $pelatihanModels = $this->createMultiple(Pelatihan::class);
            Model::loadMultiple($pelatihanModels, Yii::$app->request->post());
            $biodata->user_id = Yii::$app->user->id;

            // Validate all models
            // dd($pendidikanModels, $pekerjaanModels, $pelatihanModels);
            $valid = $biodata->validate();
            $valid = Model::validateMultiple($pendidikanModels) && $valid;
            $valid = Model::validateMultiple($pekerjaanModels) && $valid;
            $valid = Model::validateMultiple($pelatihanModels) && $valid;
            // dd($biodata->save());
            if ($valid) {
                try {
                    if ($biodata->save()) {
                        foreach ($pendidikanModels as $pendidikan) {
                            $pendidikan->biodata_id = $biodata->id;
                            if (!$pendidikan->save()) {
                                throw new \Exception('Failed to save pendidikan');
                            }
                            $pendidikan->save();
                        }
                        foreach ($pekerjaanModels as $pekerjaan) {
                            $pekerjaan->biodata_id = $biodata->id;
                            if (!$pekerjaan->save()) {
                                throw new \Exception('Failed to save pekerjaan');
                            }
                            $pekerjaan->save();
                        }
                        foreach ($pelatihanModels as $pelatihan) {
                            $pelatihan->biodata_id = $biodata->id;
                            if (!$pelatihan->save()) {
                                throw new \Exception('Failed to save pelatihan');
                            }
                            $pelatihan->save();
                        }
                        Yii::$app->session->setFlash('success', 'Data berhasil disimpan');
                        return $this->render('mydata', [
                            'biodata' => $biodata,
                            'pendidikanModels' => $pendidikanModels,
                            'pekerjaanModels' => $pekerjaanModels,
                            'pelatihanModels' => $pelatihanModels,
                        ]);
                    }
                } catch (\Exception $e) {
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        }


        // dd($pekerjaanModels);
        return $this->render('mydata', [
            'biodata' => $biodata,
            'pendidikanModels' => $pendidikanModels,
            'pekerjaanModels' => $pekerjaanModels,
            'pelatihanModels' => $pelatihanModels,
        ]);
    }



    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    public function actionPelamar($id)
    {
        $biodata = Biodata::findOne(['user_id' => $id]);
        if (!$biodata) {
            throw new \yii\web\NotFoundHttpException('The requested data does not exist.');
        }

        // Get existing related models
        $pendidikanModels = Pendidikan::findAll(['biodata_id' => $biodata->id]) ?: [new Pendidikan()];
        $pekerjaanModels = Pekerjaan::findAll(['biodata_id' => $biodata->id]) ?: [new Pekerjaan()];
        $pelatihanModels = Pelatihan::findAll(['biodata_id' => $biodata->id]) ?: [new Pelatihan()];

        if ($biodata->load(Yii::$app->request->post())) {
            // Delete existing related records
            Pendidikan::deleteAll(['biodata_id' => $biodata->id]);
            Pekerjaan::deleteAll(['biodata_id' => $biodata->id]);
            Pelatihan::deleteAll(['biodata_id' => $biodata->id]);

            // Load new data
            $pendidikanModels = $this->createMultiple(Pendidikan::class);
            Model::loadMultiple($pendidikanModels, Yii::$app->request->post());

            $pekerjaanModels = $this->createMultiple(Pekerjaan::class);
            Model::loadMultiple($pekerjaanModels, Yii::$app->request->post());

            $pelatihanModels = $this->createMultiple(Pelatihan::class);
            Model::loadMultiple($pelatihanModels, Yii::$app->request->post());

            // Validate all models
            $valid = $biodata->validate();
            $valid = Model::validateMultiple($pendidikanModels) && $valid;
            $valid = Model::validateMultiple($pekerjaanModels) && $valid;
            $valid = Model::validateMultiple($pelatihanModels) && $valid;

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($biodata->save()) {
                        // Save new records
                        foreach ($pendidikanModels as $pendidikan) {
                            $pendidikan->biodata_id = $biodata->id;
                            if (!$pendidikan->save()) {
                                throw new \Exception('Failed to save pendidikan');
                            }
                        }

                        foreach ($pekerjaanModels as $pekerjaan) {
                            $pekerjaan->biodata_id = $biodata->id;
                            if (!$pekerjaan->save()) {
                                throw new \Exception('Failed to save pekerjaan');
                            }
                        }

                        foreach ($pelatihanModels as $pelatihan) {
                            $pelatihan->biodata_id = $biodata->id;
                            if (!$pelatihan->save()) {
                                throw new \Exception('Failed to save pelatihan');
                            }
                        }

                        $transaction->commit();
                        Yii::$app->session->setFlash('success', 'Data updated successfully');
                        return $this->redirect(['/biodata']);

                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        }

        return $this->render('pelamar', [
            'biodata' => $biodata,
            'pendidikanModels' => $pendidikanModels,
            'pekerjaanModels' => $pekerjaanModels,
            'pelatihanModels' => $pelatihanModels
        ]);
    }

    public function actionDeleteBiodata($id)
    {
        $biodata = Biodata::findOne(['user_id' => $id]);
        // dd($biodata);
        if ($biodata) {
            try {
                // Delete biodata saja karna sudah cascade dari biodata ke pendidikan, pekerjaan, dan pelatihan
                if ($biodata->delete()) {
                    Yii::$app->session->setFlash('success', 'Data has been deleted successfully.');
                    if (Yii::$app->user->identity->role === 'admin') {
                        return $this->redirect(['/list']);
                    }
                    return $this->redirect(['/biodata']);
                } else {
                    throw new \Exception('Failed to delete biodata');
                }
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', 'Error deleting data: ' . $e->getMessage());
            }
        } else {
            Yii::$app->session->setFlash('error', 'Data not found');
        }

        return $this->redirect(['/biodata']);
    }

    public function actionListBiodata()
    {
        // Get current user and check their role
        $user = Yii::$app->user->identity;
        if (!$user || $user->role != 'admin') {
            Yii::$app->session->setFlash('error', 'Access denied. Admin only.');
            return $this->redirect(['/']);
        }
        $query = Biodata::find();

        // Get search parameters
        $searchParams = [
            'nama_lengkap' => Yii::$app->request->get('nama_lengkap', ''),
            'tempat_lahir' => Yii::$app->request->get('tempat_lahir', ''),
            'tanggal_lahir' => Yii::$app->request->get('tanggal_lahir', ''),
            'posisi_dilamar' => Yii::$app->request->get('posisi_dilamar', ''),
        ];

        // filter pencarian sesuai parameter
        $query = $query->andFilterWhere(['like', 'nama_lengkap', $searchParams['nama_lengkap']])
            ->andFilterWhere(['like', 'tempat_lahir', $searchParams['tempat_lahir']])
            ->andFilterWhere(['like', 'tanggal_lahir', $searchParams['tanggal_lahir']])
            ->andFilterWhere(['like', 'posisi_dilamar', $searchParams['posisi_dilamar']]);

        $pagination = new \yii\data\Pagination([
            'totalCount' => $query->count(),
            'pageSize' => 5,
        ]);

        $biodata = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        if (empty($biodata)) {
            Yii::$app->session->setFlash('info', 'No data found matching your search criteria.');
        }

        return $this->render('listBiodata', [
            'biodata' => $biodata,
            'searchParams' => $searchParams,
            'pagination' => $pagination,
        ]);
    }

}
