<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \common\models\MusicWork $model
 * @var \common\models\ImageUploadForm $imageUploadForm
 */

$this->title = $model->name . ' - Кинемотограф';

$this->params['breadcrumbs'] = [
	['label' => 'Музыкальные работы', 'url' => ['index']],
	$model->name,
];
?>
<div>
	<?= $this->render('_form', [
		'model'           => $model,
		'imageUploadForm' => $imageUploadForm,
	]) ?>
</div>
