<?php

/**
 * @var $this \yii\web\View
 * @var \yii\data\ActiveDataProvider $dataProvider
 */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$this->title = 'Кино';
?>
<div class="container">
    <div class="site-title">
		<?= Html::a($this->title, ['index']) ?>
    </div>

	<?= \yii\widgets\ListView::widget([
		'dataProvider' => $dataProvider,
		'summary'      => false,
		'layout'       => "{summary}\n{items}\n<div class='col-md-12 text-center'>{pager}</div>",
		'itemOptions'  => [
			'tag' => false,
		],
		'options'      => [
			'class' => 'row',
		],
		'itemView'     => function ($model, $key, $index, $widget) {
			return $this->render('//_cinema-work-list-item', [
				'model' => $model,
			]);
		},
	]) ?>
</div>
