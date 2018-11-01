<?php

/**
 * @var $this \yii\web\View
 * @var $content string
 */

use yii\helpers\Html;
use frontend\assets\FrontendAsset;

FrontendAsset::register($this);
\frontend\assets\ThemeAsset::register($this);
?>
<?php $this->beginContent('@app/views/layouts/plain.php') ?>
<?= $this->render('_header') ?>

    <div class="content">
        <div class="container">
			<?= \common\widgets\Alert::widget() ?>
        </div>

		<?= $content ?>
    </div>

<?= $this->render('_footer') ?>
<?php $this->endContent() ?>