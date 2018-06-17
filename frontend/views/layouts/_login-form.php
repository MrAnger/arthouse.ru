<?php

/**
 * @var $this \yii\web\View
 */

use yii\helpers\Html;
use yii\helpers\Url;

$model = new \Da\User\Form\LoginForm(\common\models\User::find(), new \Da\User\Helper\SecurityHelper(Yii::$app->security));

/** @var \Da\User\Model\User $module */
$module = Yii::$app->getModule('user');
?>
<?php $form = \yii\widgets\ActiveForm::begin([
	'action'                 => ['/user/login'],
	'enableClientValidation' => false,
	'options'                => [
		'class' => 'login-form',
	],
]) ?>

<?= $form->field(
	$model,
	'login',
	['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control input-sm', 'tabindex' => '1']]
)
	->label(false)
	->textInput([
		'maxlength'   => true,
		'placeholder' => $model->getAttributeLabel('login'),
	]) ?>

<?= $form
	->field(
		$model,
		'password',
		['inputOptions' => ['class' => 'form-control input-sm', 'tabindex' => '2']]
	)
	->label(false)
	->passwordInput([
		'maxlength'   => true,
		'placeholder' => $model->getAttributeLabel('password'),
	]) ?>

<?= $form->field($model, 'rememberMe')
	->checkbox(['tabindex' => '4', 'label' => 'Запомнить']) ?>

<?= Html::submitButton(
	Yii::t('usuario', 'Sign in'),
	['class' => 'btn btn-primary btn-block btn-sm', 'tabindex' => '3']
) ?>

<?php if ($module->allowPasswordRecovery): ?>
	<?= Html::a(
		Yii::t('usuario', 'Forgot password?'),
		['/user/recovery/request'],
		['tabindex' => '5', 'style' => 'display: block; margin-top: 5px;']
	) ?>
<?php endif; ?>

<?php \yii\widgets\ActiveForm::end() ?>
