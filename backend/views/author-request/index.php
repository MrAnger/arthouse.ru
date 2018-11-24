<?php

use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \yii\data\ActiveDataProvider $dataProvider
 */

$this->title = 'Заявки в авторы';

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
				'value'     => function (\common\models\AuthorRequest $model) {
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
			[
				'attribute' => 'about',
				'format'    => 'html',
				'value'     => function (\common\models\AuthorRequest $model) {
					return nl2br($model->about);
				},
			],
			[
				'class'          => \yii\grid\ActionColumn::class,
				'template'       => '{approve} {decline}',
				'buttons'        => [
					'approve' => function ($url, \common\models\AuthorRequest $model, $key) {
						$title = "Одобрить";

						$icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-ok"]);

						return Html::a($icon, $url, [
							'title'        => $title,
							'aria-label'   => $title,
							'data-pjax'    => '0',
							'data-confirm' => "Вы точно хотите одобрить эту заявку?",
						]);
					},
					'decline' => function ($url, \common\models\AuthorRequest $model, $key) {
						$title = "Отклонить";

						$icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-remove"]);

						return Html::a($icon, '#', [
							'title'      => $title,
							'aria-label' => $title,
							'data'       => [
								'toggle' => 'modal',
								'target' => '#modal-author-request-decline',
								'pjax'   => 0,
								'id'     => $model->id,
							],
						]);
					},
				],
				'visibleButtons' => [
					'approve' => function (\common\models\AuthorRequest $model, $key, $index) {
						return $model->status == $model::STATUS_NEW;
					},
					'decline' => function (\common\models\AuthorRequest $model, $key, $index) {
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

    <?= $this->render('_modal-decline') ?>
</div>
