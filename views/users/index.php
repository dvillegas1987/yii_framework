<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\data\SqlDataProvider;
use app\models\Rol;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="users-index">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-success" style="border-top-color:#4258A9;">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            <?= Html::encode($this->title) ?>
                        </h4>
                    </div>
                    <div class="box-body">
                        <p>                                                        
                            <?= Html::a('Crear nuevo usuario', ['create'], ['class' => 'btn btn-success']) ?>
                            <?= Html::a('Salir', ['site/index'], ['class' => 'btn btn-danger pull-right']) ?>
                        </p>    
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                //'id',
                                [
                                    'attribute' => 'adjunto_foto',
                                    'format' => 'html',
                                    'value' => function($data) { return Html::img($data->adjunto_foto, ['width'=>'40']); },
                                ],
                                'username',
                                'email:email',
                                //'password',
                                'nombre',
                                'apellido',
                                // 'authKey',
                                // 'accessToken',
                                // 'activate',
                                // 'verification_code',
                                 [
                                    'attribute' => 'role',
                                    'value' => function($model){
                                        
                                         $rol = Rol::find()->where(['codigo' => $model->role])->one();
										 $countRoles = Rol::find()->where(['codigo' => $model->role])->count();
										 $r='';
										 if($countRoles > 0 ){
										 	//return substr($rol->descripcion,7);
                                            return $rol->descripcion;
									
										 }else{
										 	return 'Indefinido';
										 }

                  
                                    },
                                    'filter'=>  ArrayHelper::map(Rol::find()->orderBy(['codigo' => SORT_ASC])->all(), 'codigo', function($model, $defaultValue) {
											        return substr($model['descripcion'],7); })
                                ],

                                ['class' => 'yii\grid\ActionColumn'],
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>