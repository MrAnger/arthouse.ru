<?php

/**
 * @var $this \yii\web\View
 * @var \yii\data\ActiveDataProvider $dataProvider
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

?>
<div class="container">
    <h1 class="site-title">
		<?= Html::a('Новости', ['index']) ?>
    </h1>

	<?= \yii\widgets\ListView::widget([
		'dataProvider' => $dataProvider,
		'summary'      => false,
		'layout' => "{summary}\n{items}\n<div class='col-md-12 text-center'>{pager}</div>",
		'itemOptions'  => [
			'tag' => false,
		],
		'options'      => [
			'class' => 'row',
		],
		'itemView'     => function ($model, $key, $index, $widget) {
			return $this->render('//_news-list-item', [
				'model' => $model,
			]);
		},
	]) ?>
</div>
