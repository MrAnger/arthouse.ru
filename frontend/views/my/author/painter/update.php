<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \common\models\PainterWork $model
 * @var \common\models\ImageUploadForm $imageUploadForm
 */

$this->title = $model->name . ' - Художественные работы';

$this->params['breadcrumbs'] = [
	['label' => 'Художественные работы', 'url' => ['index']],
	$model->name,
];
?>
<div>
	<?= $this->render('_form', [
		'model'           => $model,
		'imageUploadForm' => $imageUploadForm,
	]) ?>
</div>
