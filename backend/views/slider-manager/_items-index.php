<?php

/**
 * @var yii\web\View $this
 * @var \common\models\Slider $slider
 * @var \yii\data\ArrayDataProvider $sliderItemsDataProvider
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

\yii\jui\JuiAsset::register($this);
?>
<div>
    <p class="text-right">
		<?= Html::a('Создать слайд', ['create-item', 'id' => $slider->id], ['class' => 'btn btn-success']) ?>
    </p>

	<?= \yii\grid\GridView::widget([
		'id'           => 'image-list',
		'dataProvider' => $sliderItemsDataProvider,
		'tableOptions' => ['class' => 'table table-hover'],
		'layout'       => "{items}\n{pager}",
		'rowOptions'   => function (\common\models\SliderItem $model, $key, $index, $grid) {
			return [
				'data-id' => $model->id,
			];
		},
		'options'      => [
			'data-url-sort' => Url::to(['item-set-order']),
		],
		'columns'      => [
			[
				'attribute' => 'image_id',
				'format'    => 'raw',
				'value'     => function (\common\models\SliderItem $model) {
					return Html::a(Html::img(Yii::$app->imageManager->getThumbnailUrl($model->image)), Yii::$app->imageManager->getOriginalUrl($model->image), [
						'target'    => '_blank',
						'data-pjax' => 0,
					]);
				},
			],
			'name',
			'description:raw',
			'is_enabled:boolean',
			[
				'class'      => 'yii\grid\ActionColumn',
				'template'   => '{update} {delete}',
				'urlCreator' => function ($action, $model, $key, $index, $widget) {
					return Url::to([$action . '-item', 'id' => $key]);
				},
			],
		],
	]) ?>
</div>
