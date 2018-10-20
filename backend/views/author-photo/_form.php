<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \common\models\PhotoWork $model
 * @var \common\models\ImageUploadForm $imageUploadForm
 */

$workUrl = Yii::$app->frontendUrlManager->createAbsoluteUrl(['/author/view-photo-work-by-slug/', 'slug' => 'URL', 'username' => $model->author->user->username], true);

$imageManager = Yii::$app->imageManager;
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

            <div class="row">
                <div class="col-md-6">
					<?= $form->field($imageUploadForm, 'file')->fileInput([]) ?>
                </div>
                <div class="col-md-6 text-center">
					<?php if ($model->image_id): ?>
						<?= Html::a(Html::img($imageManager->getThumbnailUrl($model->image), [
							'class' => 'img-thumbnail',
						]), $imageManager->getOriginalUrl($model->image), [
							'target' => '_blank',
						]) ?>
					<?php endif; ?>
                </div>
            </div>

			<?= $form->field($model, 'description')->widget(\mranger\ckeditor\CKEditor::class, [
				'preset' => 'minimal',
			]) ?>
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

	<?php if (!$model->isNewRecord): ?>
		<?= $this->render('_image-list', [
			'model' => $model,
		]) ?>
	<?php endif; ?>
</div>