<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \backend\models\NewsSearch = $searchModel
 */
?>
<div>
	<?= \yii\grid\GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel'  => $searchModel,
		'tableOptions' => ['class' => 'table table-hover'],
		'columns'      => [
			[
				'attribute' => 'name',
				'format'    => 'html',
				'value'     => function (\common\models\News $model) {
					$text = $model->name;

					if ($model->isArchived) {
						$text .= " <span class='badge badge-pill badge-warning'>Архив</span>";
					}

					return Html::a($text, ['update', 'id' => $model->id]);
				},
			],
			[
				'attribute' => 'slug',
				'format'    => 'raw',
				'value'     => function (\common\models\News $model) {
					$url = \common\helpers\NewsHelper::getNewsFrontendUrl($model);

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
</div>
