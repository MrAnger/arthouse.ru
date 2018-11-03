<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \common\models\Cinema $model
 * @var \common\models\ImageUploadForm $imageUploadForm
 */

$cloneModel = clone $model;
$cloneModel->slug = 'URL';

$workUrl = \common\helpers\WriterWorkHelper::getWriterWorkFrontendUrl($cloneModel);
?>
<div>
	<?php $form = \yii\widgets\ActiveForm::begin([
		'enableClientValidation' => false,
		'options'                => [
			'enctype' => 'multipart/form-data',
		],
	]) ?>

    <div class="row">
        <div class="col-md-8">
			<?= $form->field($model, 'name')
				->textInput(['maxlength' => true])
			?>

			<?= $form->field($model, 'slug')
				->hint('Оставьте пустым, что бы ссылка сгенерировалась автоматически.')
				->textInput([
					'class'       => 'form-control url-input',
					'maxlength'   => true,
					'placeholder' => $workUrl,
				])
			?>

			<?= $form->field($model, 'intro')->widget(\mranger\ckeditor\CKEditor::class, [
				'preset' => 'minimal',
			]) ?>

			<?= $form->field($model, 'content')->widget(\mranger\ckeditor\CKEditor::class) ?>
        </div>

        <div class="col-md-4">
			<?= $form->field($model, 'meta_title')
				->textInput([
					'maxlength' => true,
				]) ?>

			<?= $form->field($model, 'meta_description')
				->textInput([
					'maxlength' => true,
				]) ?>

			<?= $form->field($model, 'meta_keywords')
				->textInput([
					'maxlength' => true,
				]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
			<?= $form->errorSummary($model) ?>

			<?= Html::submitButton(Yii::t('app.actions', 'Submit'), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

	<?php \yii\widgets\ActiveForm::end() ?>
</div>
