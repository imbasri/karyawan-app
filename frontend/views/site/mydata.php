<?php

/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */
/** @var frontend\models\Biodata $biodata */
/** @var frontend\models\Pekerjaan[] $pekerjaanModels */
/** @var frontend\models\Pendidikan[] $pendidikanModels */
/** @var frontend\models\Pelatihan[] $pelatihanModels */

use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;

$this->registerCss("
    .site-my-data {
        max-width: 100%;
        margin: 0 auto;
        padding: 20px;
        text-align: left;
    }
    
    h3 {
        margin: 30px 0 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #eee;
    }
    
    .pekerjaan-item,
    .pendidikan-item,
    .pelatihan-item {
        background: #f8f9fa;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 5px;
        position: relative;
        
    }
    
    .remove-pekerjaan,
    .remove-pendidikan,
    .remove-pelatihan {
        position: absolute;
        top: 10px;
        right: 10px;
    }
    .add-pekerjaan,
    .add-pendidikan,
    .add-pelatihan {
        margin: 10px 0 20px;
    }
    
    .form-group {
        margin: 30px 0;
        text-align: left;
    }

    .has-error .help-block {
        color: red;
    }
");

$this->title = 'My Data';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
if (Yii::$app->user->isGuest) {
    Yii::$app->response->redirect(['/login']);
    return Yii::$app->end();
}
if (Yii::$app->user->identity->role === 'admin') {
    Yii::$app->response->redirect(['/list']);
    return Yii::$app->end();
}
?>
<div class="site-my-data">
    <h1 class="mb-2"><?= Html::encode($this->title) ?></h1>

    <?php $form = \yii\widgets\ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <h3>Data Pribadi</h3>

    <?= $form->field($biodata, 'posisi_dilamar')->textInput(['maxlength' => true, 'disabled' => $biodata && $biodata->user_id == Yii::$app->user->id]) ?>
    <?= $form->field($biodata, 'nama_lengkap')->textInput(['maxlength' => true, 'disabled' => $biodata && $biodata->user_id == Yii::$app->user->id]) ?>
    <?= $form->field($biodata, 'tanggal_lahir')->textInput(['type' => 'date', 'disabled' => $biodata && $biodata->user_id == Yii::$app->user->id]) ?>
    <?= $form->field($biodata, 'tempat_lahir')->textInput(['maxlength' => true, 'disabled' => $biodata && $biodata->user_id == Yii::$app->user->id]) ?>
    <?= $form->field($biodata, 'jenis_kelamin')->dropDownList(['Laki-laki' => 'Laki-laki', 'Perempuan' => 'Perempuan'], ['disabled' => $biodata && $biodata->user_id == Yii::$app->user->id]) ?>
    <?= $form->field($biodata, 'agama')->textInput(['maxlength' => true, 'disabled' => $biodata && $biodata->user_id == Yii::$app->user->id]) ?>
    <?= $form->field($biodata, 'golongan_darah')->dropDownList([
        'A' => 'A',
        'B' => 'B',
        'AB' => 'AB',
        'O' => 'O'
    ], ['disabled' => $biodata && $biodata->user_id == Yii::$app->user->id]) ?>
    <?= $form->field($biodata, 'status_pernikahan')->dropDownList(['Menikah' => 'Menikah', 'Belum Menikah' => 'Belum Menikah'], ['disabled' => $biodata && $biodata->user_id == Yii::$app->user->id]) ?>
    <?= $form->field($biodata, 'alamat_ktp')->textarea(['rows' => 6, 'disabled' => $biodata && $biodata->user_id == Yii::$app->user->id]) ?>
    <?= $form->field($biodata, 'alamat_tinggal')->textarea(['rows' => 6, 'disabled' => $biodata && $biodata->user_id == Yii::$app->user->id]) ?>
    <?= $form->field($biodata, 'email')->textInput(['maxlength' => true, 'disabled' => $biodata && $biodata->user_id == Yii::$app->user->id]) ?>
    <?= $form->field($biodata, 'no_telp')->textInput(['type' => 'number', 'maxlength' => true, 'disabled' => $biodata && $biodata->user_id == Yii::$app->user->id]) ?>

    <?= $form->field($biodata, 'orang_terdekat')->textInput(['maxlength' => true, 'disabled' => $biodata && $biodata->user_id == Yii::$app->user->id]) ?>
    <?= $form->field($biodata, 'no_telp_orang_terdekat')->textInput(['type' => 'number', 'maxlength' => true, 'disabled' => $biodata && $biodata->user_id == Yii::$app->user->id]) ?>

    <h3>Pengalaman Kerja</h3>
    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper_pekerjaan',
        'widgetBody' => '.container-items',
        'widgetItem' => '.pekerjaan-item',
        'min' => 1,
        'insertButton' => '.add-pekerjaan',
        'deleteButton' => '.remove-pekerjaan',
        'model' => $pekerjaanModels[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'biodata_id',
            'nama_perusahaan',
            'posisi_terakhir',
            'pendapatan_terakhir',
            'tahun_masuk',
            'tahun_keluar',
        ],
    ]); ?>

    <div class="container-items">
        <?php foreach ($pekerjaanModels as $i => $pekerjaanItem): ?>
            <div class="pekerjaan-item">
                <!-- <?= $form->field($pekerjaanItem, "[$i]biodata_id")->hiddenInput(['value' => Yii::$app->user->id, 'type' => 'number'])->label(false) ?> -->

                <?= $form->field($pekerjaanItem, "[$i]nama_perusahaan")->textInput(['disabled' => $biodata && $biodata->user_id == Yii::$app->user->id]) ?>
                <?= $form->field($pekerjaanItem, "[$i]posisi_terakhir")->textInput(['disabled' => $biodata && $biodata->user_id == Yii::$app->user->id]) ?>
                <?= $form->field($pekerjaanItem, "[$i]pendapatan_terakhir")->textInput(['type' => 'number', 'min' => 0, 'disabled' => $biodata && $biodata->user_id == Yii::$app->user->id]) ?>

                <?= $form->field($pekerjaanItem, "[$i]tahun_masuk")->textInput(['type' => 'number', 'min' => 1900, 'max' => date('Y'), 'disabled' => $biodata && $biodata->user_id == Yii::$app->user->id]) ?>
                <?= $form->field($pekerjaanItem, "[$i]tahun_keluar")->textInput(['type' => 'number', 'min' => 1900, 'max' => date('Y'), 'disabled' => $biodata && $biodata->user_id == Yii::$app->user->id]) ?>
                <button type="button" class="remove-pekerjaan btn btn-danger btn-sm">Remove</button>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" class="add-pekerjaan btn btn-success btn-sm">Add Pengalaman Kerja</button>
    <?php DynamicFormWidget::end(); ?>

    <h3>Pendidikan</h3>
    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper_pendidikan',
        'widgetBody' => '.container-items-pendidikan',
        'widgetItem' => '.pendidikan-item',
        'min' => 1,
        'insertButton' => '.add-pendidikan',
        'deleteButton' => '.remove-pendidikan',
        'model' => $pendidikanModels[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'biodata_id',
            'nama_institusi',
            'jurusan',
            'tahun_lulus',
            'ipk',
        ],
    ]); ?>

    <div class="container-items-pendidikan">
        <?php foreach ($pendidikanModels as $i => $pendidikanItem): ?>
            <div class="pendidikan-item">
                <!-- <?= $form->field($pendidikanItem, "[$i]biodata_id")->hiddenInput(['value' => Yii::$app->user->id, 'type' => 'number'])->label(false) ?> -->
                <?= $form->field($pendidikanItem, "[$i]jenjang_pendidikan")->textInput(['disabled' => $biodata && $biodata->user_id == Yii::$app->user->id]) ?>
                <?= $form->field($pendidikanItem, "[$i]nama_institusi")->textInput(['disabled' => $biodata && $biodata->user_id == Yii::$app->user->id]) ?>
                <?= $form->field($pendidikanItem, "[$i]jurusan")->textInput(['disabled' => $biodata && $biodata->user_id == Yii::$app->user->id]) ?>
                <?= $form->field($pendidikanItem, "[$i]tahun_lulus")->textInput(['type' => 'number', 'min' => 1900, 'max' => date('Y'), 'disabled' => $biodata && $biodata->user_id == Yii::$app->user->id]) ?>
                <?= $form->field($pendidikanItem, "[$i]ipk")->textInput(['type' => 'number', 'min' => 0, 'max' => 4, 'step' => 0.01, 'disabled' => $biodata && $biodata->user_id == Yii::$app->user->id]) ?>
                <button type="button" class="remove-pendidikan btn btn-danger btn-sm">Remove</button>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" class="add-pendidikan btn btn-success btn-sm">Add Pendidikan</button>
    <?php DynamicFormWidget::end(); ?>

    <h3>Pelatihan</h3>
    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper_pelatihan',
        'widgetBody' => '.container-items-pelatihan',
        'widgetItem' => '.pelatihan-item',
        'min' => 1,
        'insertButton' => '.add-pelatihan',
        'deleteButton' => '.remove-pelatihan',
        'model' => $pelatihanModels[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'biodata_id',
            'nama_pelatihan',
            'sertifikat',
            'tahun',
        ],
    ]); ?>

    <div class="container-items-pelatihan">
        <?php foreach ($pelatihanModels as $i => $pelatihanItem): ?>
            <div class="pelatihan-item">

                <!-- <?= $form->field($pelatihanItem, "[$i]biodata_id")->hiddenInput(['value' => Yii::$app->user->id, 'type' => 'number'])->label(false) ?> -->
                <?= $form->field($pelatihanItem, "[$i]nama_pelatihan")->textInput(['disabled' => $biodata && $biodata->user_id == Yii::$app->user->id]) ?>
                <?= $form->field($pelatihanItem, "[$i]sertifikat")->dropDownList(['1' => 'Ada', '0' => 'Tidak Ada'], ['disabled' => $biodata && $biodata->user_id == Yii::$app->user->id]) ?>
                <?= $form->field($pelatihanItem, "[$i]tahun")->textInput(['type' => 'number', 'min' => 1900, 'max' => date('Y'), 'disabled' => $biodata && $biodata->user_id == Yii::$app->user->id]) ?>
                <button type="button" class="remove-pelatihan btn btn-danger btn-sm">Remove</button>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" class="add-pelatihan btn btn-success btn-sm">Add Pelatihan</button>
    <?php DynamicFormWidget::end(); ?>

    <?= $form->field($biodata, 'skill')->textarea(['rows' => 6, 'disabled' => $biodata && $biodata->user_id == Yii::$app->user->id]) ?>
    <?= $form->field($biodata, 'bersedia_ditempatkan')->dropDownList(['Ya' => 'Ya', 'Tidak' => 'Tidak'], ['disabled' => $biodata && $biodata->user_id == Yii::$app->user->id]) ?>
    <?= $form->field($biodata, 'penghasilan_diinginkan')->textInput(['type' => 'number', 'min' => 0, 'disabled' => $biodata && $biodata->user_id == Yii::$app->user->id]) ?>

    <div class="d-flex gap-2">
        <?php
        if ($biodata && $biodata->user_id == Yii::$app->user->id) {
            echo '<div class="form-group">';
            echo Html::a('Edit', ['biodata/' . $biodata->user_id], ['class' => 'btn btn-primary']);
            echo '</div>';
        } else {
            echo '<div class="form-group">';
            echo Html::submitButton('Save', ['class' => 'btn btn-success']);
            echo '</div>';
        }
        ?>
        <div class="form-group">
            <?= Html::a('Back', [!Yii::$app->user->isGuest && Yii::$app->user->identity->role === 'admin' ? '/list' : '/biodata'], ['class' => 'btn btn-secondary']) ?>
        </div>
    </div>
    <?php \yii\widgets\ActiveForm::end(); ?>
</div>