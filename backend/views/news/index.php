<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \backend\models\NewsSearch $searchModel
 */

$this->title = 'Новости';

$this->params['breadcrumbs'] = [
	'Новости',
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

	<?= $this->render('/_news-list', [
		'dataProvider' => $dataProvider,
		'searchModel'  => $searchModel,
	]) ?>

	<?php \yii\widgets\Pjax::end() ?>
</div>
