<?php

/**
 * @var yii\web\View $this
 * @var \common\models\Feedback $feedbackForm
 * @var string $content
 */

?>
<div class="row">
	<?php if ($content): ?>
        <div class="col-md-8">
            <div class="jumbotron">
				<?= $content ?>
            </div>
        </div>
	<?php endif; ?>

    <div class="col-md-4">
        <div class="well">
            <h3>Форма обратной связи</h3>

			<?php $form = \yii\widgets\ActiveForm::begin([
				'enableClientValidation' => true,
			]) ?>

			<?= $form->field($feedbackForm, 'name')
				->textInput(['maxlength' => true])
			?>

			<?= $form->field($feedbackForm, 'email')
				->textInput(['maxlength' => true])
			?>

			<?= $form->field($feedbackForm, 'phone')
				->widget(\yii\widgets\MaskedInput::class, [
				    'mask' => '+7 (999) 999-99-99'
				])
			?>

			<?= $form->field($feedbackForm, 'text')
				->textarea([
					'maxlength' => true,
					'rows'      => 6,
				])
			?>

			<?= $form->errorSummary($feedbackForm) ?>

			<?= \yii\helpers\Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>

			<?php \yii\widgets\ActiveForm::end() ?>
        </div>
    </div>
</div>
