<?php

use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \yii\data\ActiveDataProvider $dataProvider
 */

$this->title = 'Обратная связь';

$this->params['breadcrumbs'] = [
	$this->title,
];
?>
<div>
	<?= GridView::widget([
		'tableOptions' => ['class' => 'table table-hover'],
		'dataProvider' => $dataProvider,
		'columns'      => [
			'created_at:datetime',
			[
				'attribute' => 'status',
				'format'    => 'html',
				'value'     => function (\common\models\Feedback $model) {
					$html = "";

					$name = ArrayHelper::getValue($model::getStatusLabelList(), $model->status, $model->status);

					if ($model->status == 0) {
						$html = "<span class='badge badge-pill badge-success'>$name</span>";
					} else {
						$html = $name;
					}

					return $html;
				},
			],
			'name',
			'email:email',
			'phone',
			[
				'attribute' => 'text',
				'format'    => 'html',
				'value'     => function (\common\models\Feedback $model) {
					return nl2br($model->text);
				},
			],
			[
				'class'          => \yii\grid\ActionColumn::class,
				'template'       => '{mark-as-viewed}',
				'buttons'        => [
					'mark-as-viewed' => function ($url, \common\models\Feedback $model, $key) {
						$title = "Пометить просмотренным";

						$icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-ok"]);

						return Html::a($icon, $url, [
							'title'        => $title,
							'aria-label'   => $title,
							'data-pjax'    => '0',
							'data-confirm' => "Вы точно хотите пометить эту заявку просмотренной?",
						]);
					},
				],
				'visibleButtons' => [
					'mark-as-viewed' => function (\common\models\Feedback $model, $key, $index) {
						return $model->status == $model::STATUS_NEW;
					},
				],
				'filterOptions'  => [
					'class' => 'action-column',
				],
				'headerOptions'  => [
					'class' => 'action-column',
				],
				'options'        => [
					'class' => 'action-column',
				],
			],
		],
	]) ?>
</div>
