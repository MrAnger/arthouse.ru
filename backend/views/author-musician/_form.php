<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \common\models\MusicWork $model
 * @var \common\models\ImageUploadForm $imageUploadForm
 */

$cloneModel = clone $model;
$cloneModel->slug = 'URL';

$musicUrl = \common\helpers\MusicWorkHelper::getMusicWorkFrontendUrl($cloneModel);

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
					'placeholder' => $musicUrl,
				])
			?>

			<?= $form->field($model, 'music_url')
				->textInput([
					'maxlength'   => true,
					'placeholder' => 'http://',
				]) ?>

			<?= $form->field($model, 'music_code')
				->widget(\trntv\aceeditor\AceEditor::class, [
					'mode'             => 'php',
					'theme'            => 'chrome',
					'containerOptions' => [
						'style' => 'width: 100%; min-height: 150px',
					],
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
