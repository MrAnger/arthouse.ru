<?php

/**
 * @var yii\web\View $this
 * @var \common\models\AuthorRequest $requestForm
 * @var string $content
 */

?>
<div class="row">
	<?php if ($content): ?>
        <div class="jumbotron">
			<?= $content ?>
        </div>
	<?php endif; ?>

    <div class="well">
        <h3>Форма заявки</h3>

		<?php $form = \yii\widgets\ActiveForm::begin([
			'enableClientValidation' => true,
		]) ?>

		<?= $form->field($requestForm, 'name')
			->textInput(['maxlength' => true])
		?>

		<?= $form->field($requestForm, 'email')
			->textInput(['maxlength' => true])
		?>

		<?= $form->field($requestForm, 'about')
			->textarea([
				'maxlength' => true,
				'rows'      => 6,
			])
		?>

		<?= $form->errorSummary($requestForm) ?>

		<?= \yii\helpers\Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>

		<?php \yii\widgets\ActiveForm::end() ?>
    </div>
</div>
