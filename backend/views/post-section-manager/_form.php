<?php

/**
 * @var yii\web\View $this
 * @var \common\models\post\PostSection $model
 * @var \common\models\post\PostSectionConfig $configModel
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

?>
<div>
	<?php $form = ActiveForm::begin([
		'enableClientValidation' => false,
	]) ?>

	<?= $form->field($model, 'name')
		->hint('Будет выводиться как на публичной части так и в админке.')
		->textInput([
			'maxlength' => true,
		])
	?>

	<?= $form->field($model, 'url')
		->hint('Используется при генерации ссылки на каталог с работами, так и на саму работу. Не обязательно для заполнения.')
		->textInput([
			'maxlength' => true,
		])
	?>

	<?= $form->field($model, 'is_enabled')
		->checkbox()
	?>

    <hr>

	<?= $this->render('_form-config', [
		'model'       => $model,
		'configModel' => $configModel,
		'form'        => $form,
	]) ?>

    <div class="form-group">
		<?= Html::submitButton(($model->isNewRecord) ? Yii::t('app.actions', 'Create') : Yii::t('app.actions', 'Save'), ['class' => 'btn btn-primary btn-block']) ?>
    </div>

	<?php $form->end() ?>
</div>