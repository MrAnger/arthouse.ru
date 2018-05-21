<?php

use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \backend\models\AuthorSearch $searchModel
 * @var \yii\data\ActiveDataProvider $dataProvider
 */

$this->title = 'Список авторов';

$this->params['breadcrumbs'] = [
	$this->title,
];
?>
<div>
	<?php \yii\widgets\Pjax::begin([
		'enablePushState'    => false,
		'enableReplaceState' => true,
		'timeout'            => 6000,
	]) ?>
	<?= GridView::widget([
		'tableOptions' => ['class' => 'table table-hover'],
		'dataProvider' => $dataProvider,
		'filterModel'  => $searchModel,
		'columns'      => [
			[
				'attribute' => 'user.profile.name',
				'format'    => 'html',
				'filter'    => Html::activeTextInput($searchModel, 'name', ['class' => 'form-control']),
				'value'     => function (\common\models\Author $model) {
					$html = $model->user->profile->name;

					if ($model->user->isBlocked) {
						$html .= " <span class='badge badge-pill badge-danger'>Заблокирован</span>";
					}

					return $html;
				},
			],
			[
				'attribute' => 'user.email',
				'filter'    => Html::activeTextInput($searchModel, 'email', ['class' => 'form-control']),
			],
			[
				'label'  => 'Тип',
				'format' => 'html',
				'filter' => Html::activeDropDownList($searchModel, 'workType', [null => 'Все типы'] + $searchModel::getWorkTypeList(), ['class' => 'form-control']),
				'value'  => function (\common\models\Author $model) {
					$workTypeList = [];

					foreach ($model::getWorkTypeAttributes() as $attributeCode) {
						if ($model->{$attributeCode}) {
							$workTypeList[] = $model->getAttributeLabel($attributeCode);
						}
					}

					return ((!empty($workTypeList)) ? implode("<br>", $workTypeList) : null);
				},
			],
			[
				'class'         => \yii\grid\ActionColumn::class,
				'template'      => '{view} {update}',
				'buttons'       => [
					/*'approve' => function ($url, \common\models\AuthorRequest $model, $key) {
						$title = "Одобрить";

						$icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-ok"]);

						return Html::a($icon, $url, [
							'title'        => $title,
							'aria-label'   => $title,
							'data-pjax'    => '0',
							'data-confirm' => "Вы точно хотите одобрить эту заявку?",
						]);
					},
					*/
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
