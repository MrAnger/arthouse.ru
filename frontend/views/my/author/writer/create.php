<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \common\models\WriterWork $model
 */

$this->title = 'Создать работу';

$this->params['breadcrumbs'] = [
	['label' => 'Литература', 'url' => ['index']],
	'Создать',
];
?>
<div>
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>
