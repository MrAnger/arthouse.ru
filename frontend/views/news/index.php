<?php

/**
 * @var $this \yii\web\View
 * @var \yii\data\ActiveDataProvider $dataProvider
 */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

?>

<div>
    <div class="pull-left">
        <h1>Новости</h1>
    </div>

    <div class="pull-right" style="margin-top: 20px;">
		<?= Html::a('Архивные', ['archive'], [
			'class'     => 'btn btn-primary',
			'data-pjax' => '0',
		]) ?>
    </div>

    <div class="clearfix"></div>
</div>

<?php \yii\widgets\Pjax::begin([
	'enablePushState'    => false,
	'enableReplaceState' => true,
	'timeout'            => 6000,
]) ?>

<?= \yii\widgets\ListView::widget([
	'dataProvider' => $dataProvider,
	'summary'      => false,
	'itemOptions'  => [
		'tag' => false,
	],
	'itemView'     => function ($model, $key, $index, $widget) {
		return $this->render('_list-item', [
			'model' => $model,
		]);
	},
]) ?>

<?php \yii\widgets\Pjax::end() ?>
