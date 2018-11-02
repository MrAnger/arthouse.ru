<?php

/**
 * @var yii\web\View $this
 * @var \yii\data\ActiveDataProvider $dataProvider
 */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->title = 'Слайдеры';

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
			'code',
			[
				'class'    => 'yii\grid\ActionColumn',
				'template' => '{update} {delete}',
			],
		],
	]) ?>
</div>