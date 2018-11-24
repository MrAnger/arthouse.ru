<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \common\models\News $model
 * @var \common\models\ImageUploadForm $imageUploadForm
 */

$this->title = $model->name . ' - Новости';

$this->params['breadcrumbs'] = [
	['label' => 'Новости', 'url' => ['index']],
	$model->name,
];
?>
<div>
	<?= $this->render('/_news-form', [
		'model' => $model,
        'imageUploadForm' => $imageUploadForm,
	]) ?>
</div>
