<?php
use yii\helpers\Html;
/** @var yii\web\View $this */
$this->title = 'Data Karayawan';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="biodata-list">
    <h1 class="mb-2"><?= Html::encode($this->title) ?></h1>

    <div class="table-responsive">
        <table class="table table-success table-striped p-2">
            <thead>
                <tr>
                    <th>
                        <?= Html::beginForm('', 'get') ?>
                        Search
                    </th>
                    <th>
                        <?= Html::textInput('nama_lengkap', Yii::$app->request->get('nama_lengkap'), ['class' => 'form-control', 'placeholder' => 'Nama']) ?>
                    </th>
                    <th>
                        <?= Html::textInput('tempat_lahir', Yii::$app->request->get('tempat_lahir'), ['class' => 'form-control', 'placeholder' => 'Tempat Lahir']) ?>
                    </th>
                    <th>
                        <?= Html::textInput('tanggal_lahir', Yii::$app->request->get('tanggal_lahir'), ['class' => 'form-control', 'placeholder' => 'Tanggal Lahir']) ?>
                    </th>
                    <th>
                        <?= Html::textInput('posisi_dilamar', Yii::$app->request->get('posisi_dilamar'), ['class' => 'form-control', 'placeholder' => 'Posisi Dilamar']) ?>
                    </th>
                    
                    <th>
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                            <?= Html::endForm() ?>

                            <?= Html::a('Clear', ['site/list-biodata'], ['class' => 'btn btn-secondary']) ?>
                            <?= Html::endForm() ?>
                        </div>
                    </th>
                </tr>
                <tr>
                    <th>No.</th>
                    <th>Nama Lengkap</th>
                    <th>Tempat</th>
                    <th>Tanggal Lahir</th>
                    <th>Posisi Dilamar</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($biodata)): ?>
                    <tr>
                        <td colspan="6" class="text-center">
                            <h2>No Data Available</h2>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($biodata as $index => $data): ?>
                        <tr>
                            <td><?= $index + 1 + $pagination->page * $pagination->pageSize ?></td>
                            <td><?= Html::encode($data->nama_lengkap) ?></td>
                            <td><?= Html::encode($data->tempat_lahir) ?></td>
                            <td><?= Html::encode($data->tanggal_lahir) ?></td>
                            <td><?= Html::encode($data->posisi_dilamar) ?></td>
                            <td>
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    <?= Html::a(
                                        '<i class="fa fa-eye"></i> View',
                                        ['pelamar', 'id' => $data->user_id],
                                        ['class' => 'btn btn-primary btn-sm']
                                    ) ?>
                                    <?= Html::a(
                                        '<i class="fa fa-trash"></i> Delete',
                                        ['delete-biodata', 'id' => $data->user_id],
                                        [
                                            'class' => 'btn btn-danger btn-sm',
                                            'data' => [
                                                'confirm' => 'Are you sure you want to delete this biodata?',
                                                'method' => 'post',
                                            ],
                                        ]
                                    ) ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <?php
        echo \yii\widgets\LinkPager::widget([
            'pagination' => $pagination,
            'options' => ['class' => 'pagination justify-content-center'],
            'linkContainerOptions' => ['class' => 'page-item'],
            'linkOptions' => ['class' => 'page-link'],
            'disabledListItemSubTagOptions' => ['tag' => 'span', 'class' => 'page-link']
        ]);
        ?>
    </div>
</div>