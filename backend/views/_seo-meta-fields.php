<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \yii\base\Model $model
 * @var \yii\widgets\ActiveForm $form
 */

?>
<div>
	<?= $form->field($model, 'meta_title')
		->hint('Заголовок статьи. Отображается в "Title" страницы.')
		->textInput([
			'maxlength' => true,
		]) ?>

	<?= $form->field($model, 'meta_description')
		->hint('Описание страницы. Заполняется для поисковых роботов.')
		->textInput([
			'maxlength' => true,
		]) ?>

	<?= $form->field($model, 'meta_keywords')
		->hint('Ключевые слова страницы. Заполняется для поисковых роботов.')
		->textInput([
			'maxlength' => true,
		]) ?>
</div>
