<?php

/** @var yii\web\View $this */

$this->title = 'Karyawan Recruitment';

?>
<div class="site-index">
    <div class="p-5 mb-4 bg-transparent rounded-3">
        <div class="container-fluid py-5 text-center">
            <h1 class="display-4">Welcome to Karyawan Recruitment</h1>
            <p class="fs-5 fw-light">Platform for managing employee data and recruitment</p>
            <?php if (Yii::$app->user->isGuest): ?>
                <p><a class="text-decoration-none" href="<?= Yii::$app->urlManager->createUrl(['/login']) ?>">Login to
                        Continue</a></p>
            <?php else: ?>
                <?php if (Yii::$app->user->identity->role === 'admin'): ?>
                    <p><a class="text-decoration-none" href="<?= Yii::$app->urlManager->createUrl(['/list']) ?>">View Employee List</a></p>
                <?php else: ?>
                    <p><a class="text-decoration-none" href="<?= Yii::$app->urlManager->createUrl(['/biodata']) ?>">View your Biodata</a></p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-lg-4">
                <h2>Employee Data</h2>
                <p>Manage and view comprehensive employee information including personal details,
                    work history, and documentation.</p>
            </div>
            <div class="col-lg-4">
                <h2>Profile Management</h2>
                <p>Update and maintain your professional profile, including work experience,
                    education, and personal information.</p>
            </div>
            <div class="col-lg-4">
                <h2>Security</h2>
                <p>Your data is securely stored and protected. Only authorized personnel
                    have access to sensitive information.</p>
            </div>
        </div>
    </div>
</div>