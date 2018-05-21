<?php

use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \common\models\Author $model
 */

$searchModel = new \backend\models\NewsSearch();
$dataProvider = $searchModel->search(Yii::$app->request->getQueryParams(), ['author_id' => $model->id]);
$dataProvider->sort->defaultOrder = ['created_at' => SORT_DESC];
?>
<div>
	<?php \yii\widgets\Pjax::begin([
		'enablePushState'    => false,
		'enableReplaceState' => true,
		'timeout'            => 6000,
	]) ?>

	<?= \yii\grid\GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel'  => $searchModel,
		'columns'      => [
			'name',
			[
				'attribute' => 'slug',
				'format'    => 'raw',
				'value'     => function (\common\models\News $model) {
					$url = Yii::$app->frontendUrlManager->createAbsoluteUrl(['/news/view-by-slug', 'slug' => $model->slug], true);

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