<?php

/**
 * @var yii\web\View $this
 * @var \common\models\Slider $slider
 * @var \yii\data\ArrayDataProvider $sliderItemsDataProvider
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
	]) ?>

    <div class="row">
        <div class="col-md-6">
			<?= $form->field($slider, 'name')
				->textInput([
					'maxlength' => true,
				])
			?>
        </div>
        <div class="col-md-6">
			<?= $form->field($slider, 'code')
				->textInput([
					'maxlength' => true,
				])
			?>
        </div>

        <div class="col-md-6">
			<?= $form->field($slider, 'is_enabled')
				->checkbox() ?>
        </div>
    </div>

    <div class="form-group text-right">
		<?= Html::submitButton(($slider->isNewRecord) ? Yii::t('app.actions', 'Create') : Yii::t('app.actions', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>

	<?php $form->end() ?>

    <hr>

	<?php if (!$slider->isNewRecord): ?>
		<?= $this->render('_items-index', [
			'slider'                  => $slider,
			'sliderItemsDataProvider' => $sliderItemsDataProvider,
		]) ?>
	<?php endif; ?>
</div>
