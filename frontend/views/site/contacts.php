<?php

/**
 * @var yii\web\View $this
 * @var \common\models\Feedback $feedbackForm
 * @var \common\models\AuthorRequest $requestForm
 * @var string $content
 */

$user = Yii::$app->user;
?>
<div class="container">
    <h1 class="heading-title">Контакты</h1>

	<?php if ($content): ?>
        <div class="contact-page-text text-center">
			<?= $content ?>
        </div>
	<?php endif; ?>

    <div class="row">
        <div class="col-md-6">
            <div class="contact-form-box">
                <h2 class="contact-form-title">Обратная связь</h2>

				<?php $form = \yii\widgets\ActiveForm::begin([
					'enableClientValidation' => true,
					'fieldConfig'            => [
						'template'     => "{input}\n<span class='contact-label'>{label}</span>\n{error}\n{hint}",
						'inputOptions' => [
							'class' => 'contact-line',
						],
						'labelOptions' => [
							'class' => null,
						],
						'options'      => [

						],
					],
					'options'                => [
						'class' => 'contact-form',
					],
				]) ?>

				<?= $form->field($feedbackForm, 'name')
					->textInput(['maxlength' => true])
				?>

				<?= $form->field($feedbackForm, 'email')
					->textInput(['maxlength' => true])
				?>

				<?= $form->field($feedbackForm, 'phone')
					->widget(\yii\widgets\MaskedInput::className(), [
						'mask'    => '+7 (999) 999-99-99',
						'options' => [
							'class' => 'contact-line',
						],
					])
				?>

				<?= $form->field($feedbackForm, 'text', ['inputOptions' => ['class' => 'contact-area']])
					->textarea([
						'maxlength' => true,
					])
				?>

				<?= \yii\helpers\Html::submitButton('Отправить', ['class' => 'contact-button']) ?>

				<?php \yii\widgets\ActiveForm::end() ?>
            </div>
        </div>

        <?php if($user->can(\common\Rbac::ROLE_MASTER)): ?>
            <div class="col-md-6">
                <div class="contact-form-box">
                    <h2 class="contact-form-title">Стать автором</h2>

					<?php $formAuthorRequest = \yii\widgets\ActiveForm::begin([
						'enableClientValidation' => true,
						'fieldConfig'            => [
							'template'     => "{input}\n<span class='contact-label'>{label}</span>\n{error}\n{hint}",
							'inputOptions' => [
								'class' => 'contact-line',
							],
							'labelOptions' => [
								'class' => null,
							],
							'options'      => [

							],
						],
						'options'                => [
							'class' => 'contact-form',
						],
					]) ?>

					<?= $formAuthorRequest->field($requestForm, 'name')
						->textInput(['maxlength' => true])
					?>

					<?= $formAuthorRequest->field($requestForm, 'email')
						->textInput(['maxlength' => true])
					?>

					<?= $formAuthorRequest->field($requestForm, 'about', ['inputOptions' => ['class' => 'contact-area']])
						->label('О себе')
						->textarea([
							'maxlength'   => true,
							'placeholder' => 'Напишите немного о себе',
							'rows'        => 6,
							'style'       => 'height: 218px;',
						])
					?>

					<?= \yii\helpers\Html::submitButton('Отправить', ['class' => 'contact-button']) ?>

					<?php \yii\widgets\ActiveForm::end() ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

