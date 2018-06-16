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
<?= $this->render('_header') ?>

    <section class="main-wrapper">
        <div class="left-col">
			<?= $this->render('_left-col') ?>
        </div>

        <div class="middle-col">
			<?= \common\widgets\Alert::widget() ?>
			<?= $content ?>
        </div>
    </section>

<?= $this->render('_footer') ?>
<?php $this->endContent() ?>