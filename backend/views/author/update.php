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

$imageUploadForm = new \common\models\ImageUploadForm();

$this->registerJs(<<<JS
$('.file-upload button').click(function (e) {
    e.preventDefault();
    
    var fileUpload = $(this).parents('.file-upload'),
        uploadConfirm = fileUpload.data('upload-confirm');

    if (uploadConfirm) {
        if (confirm(uploadConfirm)) {
            fileUpload.find('input[type=file]').click();
        }
    } else {
        fileUpload.find('input[type=file]').click();
    }
});

$(document).on('change', '.file-upload input[type=file]', function (e) {
        var input = $(this),
            fileUpload = input.parents('.file-upload'),
            uploadUrl = fileUpload.data('upload-url'),
            callbackName = fileUpload.data('callback-name');

        if (uploadUrl) {
            var formData = new FormData();
            
            formData.append(yii.getCsrfParam(), yii.getCsrfToken());
            formData.append(input.attr('name'), input[0].files[0]);
            
            $.ajax({
                url: uploadUrl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (callbackName && window[callbackName]) {
                        window[callbackName](response);
                    }
                },
                error: function () {
                    alert('Произошла ошибка при выполнении запроса.');
                },
                complete: function () {
                    var newInput = $("<input type='file'>").attr('name', input.attr('name'));

                    input.replaceWith(newInput);
                }
            });
        }
});

window.avatarUploadedCallback = function() {
  location.reload();
};
JS
);
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
            <div class="text-center">
                <h3>Аватар</h3>

				<?php if ($model->user->profile->avatar_image_id !== null): ?>
                    <div style="margin-bottom: 15px;">
						<?= Html::img(Yii::$app->imageManager->getThumbnailUrl($model->user->profile->avatarImage), [
							'class' => 'img-rounded',
						]) ?>
                    </div>
				<?php endif; ?>

                <div class="file-upload" data-upload-url="<?= Url::to(['/author/upload-avatar', 'id' => $model->id]) ?>"
                     data-callback-name="avatarUploadedCallback">
                    <button type="button" class="btn btn-primary btn-xs">Загрузить аватар</button>
					<?= Html::activeFileInput($imageUploadForm, "file") ?>
                </div>
            </div>

            <h3>Типы работ</h3>

			<?= $form->field($model, 'is_painter')->checkbox() ?>
			<?= $form->field($model, 'is_cinematographer')->checkbox() ?>
			<?= $form->field($model, 'is_writer')->checkbox() ?>
			<?= $form->field($model, 'is_musician')->checkbox() ?>
			<?= $form->field($model, 'is_photo')->checkbox() ?>
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