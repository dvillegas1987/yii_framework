<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\data\SqlDataProvider;
use app\models\Rol;
/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin([
                    
                    'id' => 'ajax3','options' => ['enctype' => 'multipart/form-data'] ]); ?>
    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
        </div>
   
        <div class="col-lg-4">   
             <?php  if ($model->isNewRecord):  ?>
                <?=  $form->field($model, 'role',['enableAjaxValidation' => true])->dropDownList(
			            ArrayHelper::map(Rol::find()->orderBy(['codigo' => SORT_ASC])->all(), 'codigo', function($model, $defaultValue) {
			        //return substr($model['descripcion'],7);}));
                    return $model['descripcion'];}));
				?>
            <?php  else:  ?>

                     
                        <?php $rol = Yii::$app->user->identity->role; ?>
                        <?php if($rol == 1): ?>

                            <?php  
                            	$model->role  = $model->role; 
                            	echo $form->field($model, 'role',['enableAjaxValidation' => true])->dropDownList(
			           			 ArrayHelper::map(Rol::find()->orderBy(['codigo' => SORT_ASC])->all(), 'codigo', function($model, $defaultValue) {
					        	//return substr($model['descripcion'],7);}));
                                return $model['descripcion'];}));
							?>

                        <?php else: ?>

                        	<?=  $form->field($model, 'role',['enableAjaxValidation' => true])->dropDownList(
			           			 ArrayHelper::map(Rol::find()->orderBy(['codigo' => SORT_ASC])->all(), 'codigo', function($model, $defaultValue) {
					        	//return substr($model['descripcion'],7);}),['readOnly'=>true]);
                                return $model['descripcion'];}),['readOnly'=>true]);
							?>

                        <?php endif; ?>

                  

            <?php  endif;  ?>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-4">
           <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'apellido')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">  
        <div class="col-lg-4">   
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div> 
        <div class="col-lg-4">   
            <?php  if ($model->isNewRecord):  ?>
                <?php echo $form->field($model, 'password')->passwordInput(['maxlength' => true]); ?>
            <?php else: ?>
               <!--<?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>-->
            <?php endif; ?>
        </div>
        
    </div>
    <div class="row" >
        <div class="col-lg-4">
            <?php
                if($model->isNewRecord) {
                    $model->adjunto_foto = 'uploads/foto_perfil/foto_default.jpg';
                    echo $form->field($model, 'foto_perfil',[ 'enableClientValidation' => true, 'enableAjaxValidation' => false])->widget(FileInput::classname(), [
                        //'id' => 'file_input1',
                        //'name' => 'i1',
                        'options' => ['accept'=>'image/*'],
                       
                        'pluginOptions' => [
                            //'showPreview' => false,
                            'allowedFileExtensions'=>['jpg', 'gif', 'png', 'bmp'],
                            'showCaption' => true,
                            'showRemove' => false,
                            'showUpload' => false,
                            'showClose' => false,
                            'initialPreview'=>[
                                Html::img($model->adjunto_foto,['class'=>'file-preview-image']),
                            ],
                            'initialCaption'=> $model->adjunto_foto,
                             //'minFileCount' => 1,
                            // 'validateInitialCount' => true,
                            // 'uploadUrl' => Url::to(['cliente/upload']),
                        ],
                    ]);
                }
                else {
                    echo $form->field($model, 'foto_perfil',['enableClientValidation' => true, 'enableAjaxValidation' => false])->widget(FileInput::classname(), [
                        'id' => 'file_input1',
                        'name' => 'i1',
                        'options' => ['accept'=>'image/*'],
                        'pluginOptions' => [
                            // 'minFileCount' => 1,
                            'allowedFileExtensions'=>['jpg', 'gif', 'png', 'bmp'],
                            'showCaption' => true,
                            'showRemove' => false,
                            'showUpload' => false,
                            'showClose' => false,
                            'initialPreview'=>[
                                Html::img($model->adjunto_foto,['class'=>'file-preview-image']),
                            ],
                            'overwriteInitial'=> true,
                            'autoReplace' => true,
                            'initialCaption'=> $model->adjunto_foto,
                        ]
                    ]);
                }
            ?>

        </div>
    </div>

   
    <?= $form->field($model, 'authKey')->hiddenInput(['maxlength' => true,'readOnly'=>true])->label(false); ?>

    <?= $form->field($model, 'accessToken')->hiddenInput(['maxlength' => true,'readOnly'=>true])->label(false); ?>

    <?= $form->field($model, 'activate')->hiddenInput(['readOnly'=>true])->label(false); ?>

    <?= $form->field($model, 'verification_code')->hiddenInput(['maxlength' => true,'readOnly'=>true])->label(false); ?>
    <div class="row">  
        <div class="col-lg-12">   
            <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    

    <?php ActiveForm::end(); ?>

</div>
