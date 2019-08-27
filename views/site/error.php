<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">
    <div class="callout callout-info">
        <h4><?= Html::encode($this->title) ?></h4>

        <p><?= nl2br(Html::encode($message)) ?></p>
    </div>

    <!--<p>
        The above error occurred while the Web server was processing your request.
    </p>
    <p>
        Please contact us if you think this is a server error. Thank you.
    </p>-->

</div>
