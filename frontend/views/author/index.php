<?php

/**
 * @var $this \yii\web\View
 * @var \yii\data\ActiveDataProvider $dataProvider
 */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

?>
<div class="container">
    <h1 class="site-title">
        Авторы
    </h1>

	<?= \yii\widgets\ListView::widget([
		'dataProvider' => $dataProvider,
		'layout'       => "{summary}\n{items}\n<div class='col-md-12 text-center'>{pager}</div>",
		'summary'      => false,
		'itemOptions'  => [
			'tag' => false,
		],
		'options'      => [
			'class' => 'row',
			'style' => 'margin-right: 0;',
		],
		'itemView'     => function ($model, $key, $index, $widget) {
			return $this->render('_list-item', [
				'model' => $model,
			]);
		},
	]) ?>
</div>
