<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \common\models\WriterWork $model
 */

$this->title = $model->name . ' - Литература';

$this->params['breadcrumbs'] = [
	['label' => 'Литература', 'url' => ['index']],
	$model->name,
];
?>
<div>
	<?= $this->render('@backend/views/author-writer/_form', [
		'model' => $model,
	]) ?>
</div>
