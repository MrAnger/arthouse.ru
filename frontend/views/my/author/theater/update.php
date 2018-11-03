<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \common\models\Theater $model
 * @var \common\models\ImageUploadForm $imageUploadForm
 */

$this->title = $model->name . ' - Театр';

$this->params['breadcrumbs'] = [
	['label' => 'Театр', 'url' => ['index']],
	$model->name,
];
?>
<div>
	<?= $this->render('@backend/views/author-theater/_form', [
		'model'           => $model,
		'imageUploadForm' => $imageUploadForm,
	]) ?>
</div>
