<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \common\models\WriterWork $model
 */

$this->title = $model->name . ' - Писательские работы';

$this->params['breadcrumbs'] = [
	['label' => 'Писательские работы', 'url' => ['index']],
	$model->name,
];
?>
<div>
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>
