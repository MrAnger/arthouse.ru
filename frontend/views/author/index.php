<?php

/**
 * @var $this \yii\web\View
 * @var \yii\data\ActiveDataProvider $dataProvider
 */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$this->title = 'Авторы';
?>

<h1><?= $this->title ?></h1>

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
