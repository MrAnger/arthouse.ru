<?php

/**
 * @var $this yii\web\View
 * @var $name string
 * @var $message string
 * @var $exception Exception
 */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="content">
    <div class="error-404-header">
        <div class="container">
            <h1 class="site-text-color">Ошибка</h1>
        </div>
    </div>

    <div class="container">
        <div class="error-404">
            <h2><?= Html::encode($this->title) ?></h2>

            <p><?= nl2br(Html::encode($message)) ?></p>

            <p>
                The above error occurred while the Web server was processing your request.
            </p>

            <p>
                Please contact us if you think this is a server error. Thank you.
            </p>
        </div>
    </div>
</div>
