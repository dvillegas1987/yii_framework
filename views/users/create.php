<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'Nuevo usuario';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="users-create">
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
			            <?= $this->render('_form', [
					        'model' => $model,
					    ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
