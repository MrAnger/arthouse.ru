<?php

/**
 * @var $this \yii\web\View
 * @var $content string
 */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\FrontendAsset;

FrontendAsset::register($this);
?>
<?php $this->beginContent('@app/views/layouts/main.php') ?>

<?php if (isset($this->params['breadcrumbs'])): ?>
	<?= \yii\widgets\Breadcrumbs::widget([
		'links' => array_merge([['label' => 'Личный кабинет', 'url' => ['/user/settings/profile']]], $this->params['breadcrumbs']),
	]) ?>
<?php endif; ?>

<?= $content ?>
<?php $this->endContent() ?>