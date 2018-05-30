<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \common\models\PainterWork $model
 */

$this->registerAssetBundle(\yii\jui\JuiAsset::class);

$imageManager = Yii::$app->imageManager;
?>
<hr>
<div>
    <h3>Изображения</h3>

	<?php \yii\widgets\Pjax::begin([
		'id'                 => 'pjax-image-list',
		'enablePushState'    => false,
		'enableReplaceState' => true,
		'timeout'            => 6000,
		'options'            => [
			'class' => 'js-pjax',
		],
	]) ?>

	<?= \yii\grid\GridView::widget([
		'id'           => 'image-list',
		'dataProvider' => new \yii\data\ArrayDataProvider([
			'allModels'  => $model->getImages()->all(),
			'pagination' => false,
		]),
		'layout'       => "{items}\n{pager}",
		'rowOptions'   => function (\MrAnger\Yii2_ImageManager\models\Image $model, $key, $index, $grid) {
			return [
				'data-id' => $model->id,
			];
		},
		'options'      => [
			'data-url-sort' => Url::to(['set-order-image']),
		],
		'columns'      => [
			[
				'attribute' => 'file',
				'label'     => 'Изображение',
				'format'    => 'raw',
				'value'     => function (\MrAnger\Yii2_ImageManager\models\Image $model) use ($imageManager) {
					return Html::a(Html::img($imageManager->getThumbnailUrl($model), [
						'class' => 'img-thumbnail',
					]), $imageManager->getOriginalUrl($model), [
						'target'    => '_blank',
						'data-pjax' => 0,
					]);
				},
			],
			'title',
			'description',
			[
				'class'         => \yii\grid\ActionColumn::class,
				'template'      => '{update} {delete}',
				'buttons'       => [
					'update' => function ($url, \MrAnger\Yii2_ImageManager\models\Image $model, $key) {
						$title = Yii::t('yii', 'Update');

						$options = [
							'title'      => $title,
							'aria-label' => $title,
							'data'       => [
								'title'       => $model->title,
								'description' => $model->description,
								'toggle'      => 'modal',
								'target'      => '#modal-image-update',
								'url'         => Url::to(['update-image', 'imageId' => $model->id]),
							],
						];

						return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#', $options);
					},
					'delete' => function ($url, \MrAnger\Yii2_ImageManager\models\Image $model, $key) {
						$title = Yii::t('yii', 'Delete');

						$options = [
							'class'      => 'js-image-delete',
							'title'      => $title,
							'aria-label' => $title,
							'data-url'   => Url::to(['delete-image', 'imageId' => $model->id]),
						];

						return Html::a('<span class="glyphicon glyphicon-trash"></span>', '#', $options);
					},
				],
				'filterOptions' => [
					'class' => 'action-column',
				],
				'headerOptions' => [
					'class' => 'action-column',
				],
				'options'       => [
					'class' => 'action-column',
				],
			],
		],
	]) ?>

	<?php \yii\widgets\Pjax::end() ?>
</div>
<?= $this->render('_modal-image-update') ?>
