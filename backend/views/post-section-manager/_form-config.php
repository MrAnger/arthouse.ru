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

$this->registerJsFile('@web/static/js/post-section.form.js', ['depends' => [\backend\assets\BackendAsset::className()],]);
$this->registerCss(<<<CSS
#post-enabled-field-list .form-group {
    margin-left: 50px;
}
CSS
);
?>
<div>
    <h2>Настройки раздела</h2>

	<?= $form->field($configModel, 'displayOnHomePage')
		->hint('Включите, если хотите что бы данный раздел выводился на главной странице сайта.')
		->checkbox()
	?>

	<?= $form->field($configModel, 'entryNameMany')
		->hint('Будет выводиться как на публичной части так и в админке.')
		->textInput([
			'maxlength' => true,
		])
	?>

	<?= $form->field($configModel, 'entryNameSingle')
		->hint('Будет выводиться как на публичной части так и в админке.')
		->textInput([
			'maxlength' => true,
		])
	?>

	<?= $form->field($configModel, 'homePageTitle')
		->hint('Будет выводиться на публичной части.')
		->textInput([
			'maxlength' => true,
		])
	?>

	<?= $form->field($configModel, 'otherPostsWithAuthorLabel')
		->hint('Будет выводиться на публичной части.')
		->textInput([
			'maxlength' => true,
		])
	?>

	<?= $form->field($configModel, 'otherPostsLabel')
		->hint('Будет выводиться на публичной части.')
		->textInput([
			'maxlength' => true,
		])
	?>

    <hr>

    <h2>Настройки контента</h2>

    <div class="row">
        <div class="col-md-6">
			<?= $form->field($configModel, 'enabledFields')
				->hint('Отметьте галочками те поля, из которых будет состоять работа раздела.')
				->checkboxList($configModel->getPostFields(), [
					'id'    => 'post-enabled-field-list',
					'class' => 'checkbox-list-item',
					'item'  => function ($index, $label, $name, $checked, $value) use ($form, $configModel) {
						if ($value == 'name') {
							$checked = true;
						}

						$inputOptions = [
							'value' => $value,
							'label' => $label,
						];

						if ($value == 'name') {
							$inputOptions['disabled'] = 'disabled';
						}

						$inputHtml = Html::checkbox($name, $checked, $inputOptions);

						if ($value == 'name') {
							$inputHtml = Html::hiddenInput($name, $value) . $inputHtml;
						}

						$fieldLabelsInputHtmlList = [];

						$generateInputWrapperClass = function ($checked) {
							$classList = ['form-group'];

							if (!$checked) {
								$classList[] = 'hidden';
							}

							return implode(' ', $classList);
						};

						$fieldLabelsInputHtmlList[] = $form->field($configModel, sprintf("fieldLabels[%s][label]", $value), [
							'options' => [
								'class' => $generateInputWrapperClass($checked),
							],
						])
							->label('Название поля')
							->hint('Введите новое название поля, если стандартное название не подходит по смыслу или значению. Не обязательно для заполнения.')
							->textInput([
								'class' => 'form-control input-sm',
							]);

						$fieldLabelsInputHtmlList[] = $form->field($configModel, sprintf("fieldLabels[%s][hint]", $value), [
							'options' => [
								'class' => $generateInputWrapperClass($checked),
							],
						])
							->label('Подсказка')
							->hint('Введите пояснительную подсказку по использованию данного поля. Не обязательно для заполнения.')
							->textInput([
								'class' => 'form-control input-sm',
							]);

						if ($value != 'imageGallery') {
							$inputOptions = [
								'value'   => $value,
								'label'   => 'Обязательное поле',
								'uncheck' => false,
							];

							$hiddenInput = '';

							if ($value == 'name') {
								$inputOptions['disabled'] = 'disabled';

								$configModel->requiredFields[$value] = $value;

								$hiddenInput = $form->field($configModel, sprintf("requiredFields[%s]", $value))
									->label(false)
									->hint(false)
									->hiddenInput();
							}

							$fieldLabelsInputHtmlList[] = $form->field($configModel, sprintf("requiredFields[%s]", $value), [
									'options' => [
										'class' => $generateInputWrapperClass($checked),
									],
								])
									->hint('Включите, если хотите требовать заполнения данного поля.')
									->checkbox($inputOptions) . $hiddenInput;
						}

						return $inputHtml . implode("\n", $fieldLabelsInputHtmlList);
					},
				])
			?>
        </div>
    </div>

    <hr>

    <h2>Настройки внешнего вида работ на главной странице сайта</h2>

	<?= $form->field($configModel, 'previewHomePageDisplayConfig')
		->hint('Отметьте галочками те поля, из которых будет состоять внешний вид работы на главной странице сайта.')
		->checkboxList($configModel->getPreviewDisplayConfigParamList(), [
			'class' => 'checkbox-list-item',
		])
	?>
</div>