<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \common\models\News $model
 * @var \common\models\ImageUploadForm $imageUploadForm
 */

$this->title = 'Создать новость';

$this->params['breadcrumbs'] = [
	['label' => 'Новости', 'url' => ['index']],
	'Создать',
];
?>
<div>
	<?= $this->render('@backend/views/_news-form', [
		'model' => $model,
		'imageUploadForm' => $imageUploadForm,
	]) ?>
</div>
