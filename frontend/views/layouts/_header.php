<?php

/**
 * @var $this \yii\web\View
 */

use yii\helpers\Html;
use yii\helpers\Url;

if (!isset($this->params['breadcrumbs'])) {
	$this->params['breadcrumbs'] = [];
}
?>
<header>
    <div class="header-wrapper">
        <a href="<?= Yii::$app->homeUrl ?>">
            <img src="static/images/logo.gif" alt=""/>
        </a>
    </div>
    <div class="header-tail">
        <div class="breadcrumb-wrapper">
            <div class="breadcrumb-content">
				<?= \yii\widgets\Breadcrumbs::widget([
					'links' => $this->params['breadcrumbs'],
				]) ?>
            </div>
        </div>
    </div>
</header>