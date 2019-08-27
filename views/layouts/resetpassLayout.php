<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
//use yii\bootstrap\Nav;
//use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\DashboardAsset;

DashboardAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="hold-transition login-page">
<?php $this->beginBody() ?>


<div class="login-box">

    <div class="login-logo">
        <a><b>Admin</b> FINANZAS</a>
    </div><!-- /.login-logo -->

    <div class="box box-success"  style="border-top-color:#4258A9;">
        <div class="box-header with-border">
        <h3 class="box-title">Generación de nueva contraseña</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <?= $content ?>
        </div>
        <!-- /.box-body -->
    </div>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>



