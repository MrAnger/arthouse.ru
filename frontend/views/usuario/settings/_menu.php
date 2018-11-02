<?php

/*
 * This file is part of the 2amigos/yii2-usuario project.
 *
 * (c) 2amigOS! <http://2amigos.us/>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

/**
 * @var \yii\web\View $this
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Menu;

/** @var \common\models\User $user */
$user = Yii::$app->user->identity;
$networksVisible = count(Yii::$app->authClientCollection->clients) > 0;

$avatarUrl = Yii::$app->imageManager->getThumbnailUrlByFile('@frontend/web/static/images/img-profile.png');
if ($user->profile->avatar_image_id) {
	$avatarUrl = Yii::$app->imageManager->getThumbnailUrl($user->profile->avatarImage);
}

$imageUploadForm = new \common\models\ImageUploadForm();

$this->registerJs(<<<JS
$('.avatar-upload img').click(function (e) {
    e.preventDefault();
    
    var fileUpload = $(this).parents('.avatar-upload'),
        uploadConfirm = fileUpload.data('upload-confirm');

    if (uploadConfirm) {
        if (confirm(uploadConfirm)) {
            fileUpload.find('input[type=file]').click();
        }
    } else {
        fileUpload.find('input[type=file]').click();
    }
});

$(document).on('change', '.avatar-upload input[type=file]', function (e) {
        var input = $(this),
            fileUpload = input.parents('.avatar-upload'),
            uploadUrl = fileUpload.data('upload-url');

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
                    location.reload();
                },
                error: function () {
                    alert('Произошла ошибка при выполнении запроса.');
                },
                complete: function () {
                    var newInput = $("<input type='file'>")
                        .attr('name', input.attr('name'))
                        .addClass('hidden');

                    input.replaceWith(newInput);
                }
            });
        }
});
JS
);
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            <div class="avatar-upload" data-upload-url="<?= Url::to(['/my/author/profile/upload-avatar']) ?>">
				<?= Html::img(
					$avatarUrl,
					[
						'class' => 'img-rounded',
						'alt'   => $user->profile->name,
						'style' => 'cursor: pointer;',
					]
				) ?>
				<?= Html::activeFileInput($imageUploadForm, "file", [
					'class' => 'hidden',
				]) ?>
            </div>

			<?= $user->profile->name ?>
        </h3>
    </div>

    <div class="panel-body">
		<?= Menu::widget(
			[
				'options' => [
					'class' => 'nav nav-pills nav-stacked',
				],
				'items'   => [
					['label' => Yii::t('usuario', 'Profile'), 'url' => ['/user/settings/profile']],
					['label' => Yii::t('usuario', 'Account'), 'url' => ['/user/settings/account']],
					[
						'label'   => Yii::t('usuario', 'Networks'),
						'url'     => ['/user/settings/networks'],
						'visible' => $networksVisible,
					],
				],
			]
		) ?>
    </div>
</div>
