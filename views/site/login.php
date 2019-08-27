<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        
    ]); ?>

        <div class="form-group has-feedback">
            <?= $form->field($model, 'username')->textInput()->label('Usuario') ?>
        </div>

        <div class="form-group has-feedback">
            <?= $form->field($model, 'password')->passwordInput()->label('Contraseña') ?>
        </div>

        <div class="form-group has-feedback">
            <?= $form->field($model, 'rememberMe')->checkbox(['value' => false])->label('Mantener sesión iniciada') ?>
        </div>
   
        <div class="form-group has-feedback">
           
              <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button','style'=>'float: right']) ?>
          
        </div>

    <?php ActiveForm::end(); ?>

</div>
