<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \common\models\MusicWork $model
 * @var \common\models\ImageUploadForm $imageUploadForm
 */

$this->title = 'Создать работу';

$this->params['breadcrumbs'] = [
	['label' => 'Музыка', 'url' => ['index']],
	'Создать',
];
?>
<div>
	<?= $this->render('@backend/views/author-musician/_form', [
		'model'           => $model,
		'imageUploadForm' => $imageUploadForm,
	]) ?>
</div>
