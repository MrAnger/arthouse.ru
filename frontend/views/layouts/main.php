<?php

/**
 * @var $this \yii\web\View
 * @var $content string
 */

use yii\helpers\Html;
use frontend\assets\FrontendAsset;

FrontendAsset::register($this);
?>
<?php $this->beginContent('@app/views/layouts/plain.php') ?>
<?= $this->render('//_head-menu') ?>

    <div class="main-content">
        <div class="container">
			<?= \common\widgets\Alert::widget() ?>
			<?= $content ?>
        </div>
    </div>

<?= $this->render('//_footer') ?>
<?php $this->endContent() ?>