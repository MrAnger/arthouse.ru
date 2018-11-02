<?php

/**
 * @var yii\web\View $this
 * @var \common\models\SliderItem $sliderItem
 * @var \common\models\ImageUploadForm $imageUploadForm
 */

use trntv\aceeditor\AceEditor;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

?>
<div>
	<?php $form = ActiveForm::begin([
		'enableClientValidation' => false,
		'options'                => [
			'enctype' => 'multipart/form-data',
		],
	]) ?>

    <div class="row">
        <div class="col-md-8">
			<?= $form->field($sliderItem, 'name')
				->textInput([
					'maxlength' => true,
				])
			?>

			<?= $form->field($sliderItem, 'description')->widget(\mranger\ckeditor\CKEditor::className(), [
				'preset' => 'minimal',
			])
			?>

			<?= $form->field($sliderItem, 'is_enabled')
				->checkbox() ?>
        </div>

        <div class="col-md-4">
            <div class="text-center">
				<?php if ($sliderItem->image_id): ?>
					<?= Html::a(Html::img(Yii::$app->imageManager->getThumbnailUrl($sliderItem->image), [
						'class' => 'img-thumbnail',
					]), Yii::$app->imageManager->getOriginalUrl($sliderItem->image), [
						'target' => '_blank',
					]) ?>
				<?php endif; ?>
            </div>

			<?= $form->field($imageUploadForm, 'file')->fileInput() ?>
        </div>
    </div>

    <div class="form-group text-left">
		<?= Html::submitButton(($sliderItem->isNewRecord) ? Yii::t('app.actions', 'Create') : Yii::t('app.actions', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>

	<?php $form->end() ?>
</div>
