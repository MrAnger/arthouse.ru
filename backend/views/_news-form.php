<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \common\models\News $model
 */

$formatter = Yii::$app->formatter;

$newsUrl = Yii::$app->frontendUrlManager->createAbsoluteUrl(['/news/view-by-slug', 'slug' => 'URL'], true);

if ($model->author_id !== null) {
	$newsUrl = Yii::$app->frontendUrlManager->createAbsoluteUrl(['/author/view-news-by-slug/', 'slug' => 'URL', 'username' => $model->author->user->username], true);
}
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

			<?= $form->field($model, 'intro')->widget(\mranger\ckeditor\CKEditor::class) ?>

			<?= $form->field($model, 'content')->widget(\mranger\ckeditor\CKEditor::class) ?>
        </div>

        <div class="col-md-4">
			<?= $form->field($model, 'archive_at')
				->hint((($model->isArchived) ? "Архивированно " . $formatter->asDatetime($model->archived_at) : false))
				->widget(\kartik\datecontrol\DateControl::class, [
					'type'     => \kartik\datecontrol\DateControl::FORMAT_DATETIME,
					'disabled' => $model->isArchived,
				]) ?>

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
