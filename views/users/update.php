<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'Actualización de usuario';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="users-update">
	<section class="content"> 
	    <div class="row">
	        <div class="col-xs-12">
	          <div class="box" style="border-top-color:#4258A9;">
	            <div class="box-header with-border">
	                <h4 class="box-title">
	                   <?= Html::encode($this->title) ?>
	                </h4>
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body">
	                <?= $this->render('_form', [
				        'model' => $model,
				    ]) ?>
	            </div>
	            <!-- /.box-body -->
	          </div>
	          <!-- /.box -->
	          <!-- /.box -->
	        </div>
	        <!-- /.col -->
	    </div>
	      <!-- /.row -->
	</section>
</div>