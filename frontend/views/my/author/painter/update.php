<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \common\models\PainterWork $model
 * @var \common\models\ImageUploadForm $imageUploadForm
 */

$this->title = $model->name . ' - Галерея';

$this->params['breadcrumbs'] = [
	['label' => 'Галерея', 'url' => ['index']],
	$model->name,
];
?>
<div>
	<?= $this->render('_form', [
		'model'           => $model,
		'imageUploadForm' => $imageUploadForm,
	]) ?>
</div>
