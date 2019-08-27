<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
	use app\models\Rol;
	//use dosamigos\datepicker\DatePicker;
	use kartik\date\DatePicker;
	use yii\web\response;
	?>

	<h3><?= $msg ?></h3>


<?php $form = ActiveForm::begin([
	    'method' => 'post',
		'id' => 'formulario',
		
	]);
?>

	<div class="row">
	    <div class="col-lg-6">
	         <?= $form->field($model, "username")->input("text",['maxlength' => true]) ?>  
	    </div>   
	    <div class="col-lg-6">
	         <?= $form->field($model, "email")->input("email",['maxlength' => true]) ?>   
	    </div>        
	</div>
	<div class="row">
	    <div class="col-lg-6">
	        <?= $form->field($model, "password")->input("password",['maxlength' => true]) ?>
	    </div>
	    <div class="col-lg-6">
	         <?= $form->field($model, "password_repeat")->input("password",['maxlength' => true]) ?>    
	    </div>        
	</div>
	<div class="row">
	    <div class="col-lg-6">
	        <?= $form->field($model, "nombre")->input("text",['maxlength' => true]) ?>  
	    </div>
	    <div class="col-lg-6">
	        <?= $form->field($model, "apellido")->input("text",['maxlength' => true]) ?>   
	    </div>        
	</div>
	<div class="row">
	    <div class="col-lg-4">
	 

			<?= $form->field($model, 'role')->dropDownList(
				ArrayHelper::map(Rol::find()->orderBy(['codigo' => SORT_ASC])->all(), 'codigo', function($model, $defaultValue) { 
					return substr($model['descripcion'],7); })) 
			?>
	    </div>
	        
	</div>
	<div class="form-group">
	    <?= Html::submitButton("Registrar", ["class" => "btn btn-primary", "style"=>"float:right"]) ?>
	</div>

<?php $form->end()?>



<!--<?php
	/*use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
	//use dosamigos\datepicker\DatePicker;
	use kartik\date\DatePicker;
	use yii\web\response;
	?>

	<h3><?= $msg ?></h3>


<?php $form = ActiveForm::begin([
	    'method' => 'post',
		'id' => 'formulario',
	]);
?>

	<div class="row">
	    <div class="col-lg-6">
	         <?= $form->field($model, "username")->input("text",['maxlength' => true]) ?>  
	    </div>   
	    <div class="col-lg-6">
	         <?= $form->field($model, "email")->input("email",['maxlength' => true]) ?>   
	    </div>        
	</div>
	<div class="row">
	    <div class="col-lg-6">
	        <?= $form->field($model, "password")->input("password",['maxlength' => true]) ?>
	    </div>
	    <div class="col-lg-6">
	         <?= $form->field($model, "password_repeat")->input("password",['maxlength' => true]) ?>    
	    </div>        
	</div>
	<div class="row">
	    <div class="col-lg-6">
	        <?= $form->field($model, "nombre")->input("text",['maxlength' => true]) ?>  
	    </div>
	    <div class="col-lg-6">
	        <?= $form->field($model, "apellido")->input("text",['maxlength' => true]) ?>   
	    </div>        
	</div>
	<div class="row">
	    <div class="col-lg-2">
	        
			<?php $roles = [10,20,30,40,50,60,70,80]; ?>
			<?= $form->field($model, 'role')->dropDownList($roles)->label('Rol'); ?>
	    </div>
	        
	</div>
	<div class="form-group">
	    <?= Html::submitButton("Registrar", ["class" => "btn btn-primary", "style"=>"float:right"]) ?>
	</div>

<?php $form->end() */?>-->