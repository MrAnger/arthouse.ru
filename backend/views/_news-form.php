<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \common\models\News $model
 * @var \common\models\ImageUploadForm $imageUploadForm
 */

$formatter = Yii::$app->formatter;

$cloneModel = clone $model;
$cloneModel->slug = 'URL';

$newsUrl = \common\helpers\NewsHelper::getNewsFrontendUrl($cloneModel);

$imageManager = Yii::$app->imageManager;
?>
<div>
	<?php $form = \yii\widgets\ActiveForm::begin([
		'enableClientValidation' => false,
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
					'placeholder' => $newsUrl,
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

			<?= $form->field($model, 'intro')->widget(\mranger\ckeditor\CKEditor::class, [
				'preset' => 'minimal',
			]) ?>

			<?= $form->field($model, 'content')->widget(\mranger\ckeditor\CKEditor::class) ?>
        </div>

        <div class="col-md-4">
			<?= $form->field($model, 'archive_at')
				->hint((($model->isArchived) ? "Архивированно " . $formatter->asDatetime($model->archived_at) : false))
				->widget(\kartik\datecontrol\DateControl::class, [
					'type'     => \kartik\datecontrol\DateControl::FORMAT_DATETIME,
					'disabled' => $model->isArchived,
					'readonly' => true,
				]) ?>

			<?= $this->render('@backend/views/_seo-meta-fields', [
				'model' => $model,
				'form'  => $form,
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
