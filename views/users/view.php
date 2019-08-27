<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\data\SqlDataProvider;
use app\models\Rol;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'Perfil';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php 
	 $rol = Rol::find()->where(['codigo' => $model->role])->one();
	 $countRoles = Rol::find()->where(['codigo' => $model->role])->count();
	 $r='';
	 if($countRoles > 0 ){
	 	$r = substr($rol->descripcion,7);
	 }else{
	 	$r = 'Indefinido';
	 }
?>
<div class="users-view">
    <section class="content"> 
        <div class="row">
            <div class="col-xs-12">
              <div class="box" style="border-top-color:#4258A9;">
                <div class="box-header with-border">
                    <h4 class="box-title">
                       <b><?= Html::encode($this->title) ?></b>
                    </h4>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                     <p>
                        <?= Html::a('Editar datos', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <!--<?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Está seguro de realizar esta acción?',
                                'method' => 'post',
                            ],
                        ]) ?>-->
                        <?php if($model->role == 1): ?>
                            <?= Html::a('Editar otros usuarios', ['index'], ['class' => 'btn btn-primary']) ?>
                        <?php endif; ?>

                        <?= Html::a('Salir', ['users/index'], ['class' => 'btn btn-danger pull-right']) ?>
                    </p>
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'username',
                            'email:email',
                            'password',
                            'nombre',
                            'apellido',
                            //'authKey',
                           //'accessToken',
                            //'activate',
                            //'verification_code',

                            [
                                'attribute' => 'role',
                                'format'=>'raw',
                                'value'=> $r
                            ],
                            [
                                'attribute' => 'adjunto_foto',
                                'format' => 'html',
                                'value' => Html::img($model->adjunto_foto, ['width'=>'80']),
                            ],

                        ],
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