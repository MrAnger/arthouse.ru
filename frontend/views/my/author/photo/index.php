<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \backend\models\PhotoWorkSearch $searchModel
 */

$this->title = 'Фото';

$this->params['breadcrumbs'] = [
	'Фото',
];

?>
<div>
    <p class="text-right">
		<?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

	<?php \yii\widgets\Pjax::begin([
		'enablePushState'    => false,
		'enableReplaceState' => true,
		'timeout'            => 6000,
	]) ?>

	<?= \yii\grid\GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel'  => $searchModel,
		'tableOptions' => ['class' => 'table table-hover'],
		'columns'      => [
			[
				'attribute' => 'name',
				'format'    => 'html',
				'value'     => function (\common\models\PhotoWork $model) {
					return Html::a($model->name, ['update', 'id' => $model->id]);
				},
			],
			[
				'attribute' => 'slug',
				'format'    => 'raw',
				'value'     => function (\common\models\PhotoWork $model) {
					$url = \common\helpers\PhotoWorkHelper::getPhotoWorkFrontendUrl($model);

					return Html::a($url, $url, [
						'target'    => '_blank',
						'data-pjax' => 0,
					]);
				},
			],
			[
				'attribute' => 'created_at',
				'format'    => 'datetime',
				'filter'    => false,
			],
			[
				'class'         => \yii\grid\ActionColumn::class,
				'template'      => '{update} {delete}',
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
