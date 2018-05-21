<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \common\models\Author $model
 */

$this->title = 'Редактирование автора - ' . $model->user->displayName;

$this->params['breadcrumbs'] = [
	['label' => 'Список авторов', 'url' => ['index']],
	['label' => $model->user->displayName, 'url' => ['view', 'id' => $model->id]],
	'Редактирование',
];

$userEditUrl = Url::to(['/user/admin/update', 'id' => $model->user_id]);

?>
<div class="model-update">
	<?php $form = \yii\widgets\ActiveForm::begin([
		'enableClientValidation' => false,
	]) ?>

    <div class="row">
        <div class="col-md-6">
            <h3>Информация профиля</h3>

            <small>
                Редактировать профиль пользователя можно в соответствующем разделе
                <a href="<?= $userEditUrl ?>"><?= $userEditUrl ?></a>
            </small>

			<?= $form->field($model->user, 'username')->textInput([
				'disabled' => 'disabled',
			]) ?>

			<?= $form->field($model->user->profile, 'name')->textInput([
				'disabled' => 'disabled',
			]) ?>

			<?= $form->field($model->user, 'email')->textInput([
				'type'     => 'email',
				'disabled' => 'disabled',
			]) ?>

			<?= $form->field($model->user->profile, 'bio')->textarea([
				'disabled' => 'disabled',
				'rows'     => 5,
			]) ?>
        </div>

        <div class="col-md-6">
            <h3>Типы работ</h3>

			<?= $form->field($model, 'is_painter')->checkbox() ?>
			<?= $form->field($model, 'is_cinematographer')->checkbox() ?>
			<?= $form->field($model, 'is_writer')->checkbox() ?>
			<?= $form->field($model, 'is_musician')->checkbox() ?>
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
