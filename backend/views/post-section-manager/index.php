<?php

/**
 * @var yii\web\View $this
 * @var \yii\data\ActiveDataProvider $dataProvider
 */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->title = Yii::$app->controller::MENU_KEY;

$this->params['breadcrumbs'] = [
	$this->title,
];
?>
<div>

    <p class="text-right">
		<?= Html::a(Yii::t('app.actions', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'tableOptions' => ['class' => 'table table-hover'],
		'columns'      => [
			'name',
			[
				'label' => 'Кол-во работ',
				'value' => function (\common\models\post\PostSection $model) {
					$count = $model->getPosts()->count();

					return Yii::$app->formatter->asInteger($count);
				},
			],
			[
				'attribute' => 'url',
				'format'    => 'raw',
				'value'     => function (\common\models\post\PostSection $model) {
					$url = Yii::$app->postManager->getSectionFrontendUrl($model);

					return Html::a($url, $url, [
						'target' => '_blank',
					]);
				},
			],
			[
				'class'    => 'yii\grid\ActionColumn',
				'template' => '{update} {delete}',
			],
		],
	]) ?>
</div>