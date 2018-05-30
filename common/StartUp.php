<?php

namespace common;

use common\models\Cinema;
use common\models\MusicWork;
use common\models\PainterWork;
use common\models\Profile;
use common\models\User;
use Yii;
use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\db\AfterSaveEvent;

/**
 * @author MrAnger
 */
class StartUp implements BootstrapInterface {

	/**
	 * @inheritDoc
	 */
	public function bootstrap($app) {
		// После создания нового профиля пользователя, проверяем настроен ли емайл gravatar, если нет, то устанавливаем его принудительно
		Event::on(Profile::class, Profile::EVENT_AFTER_INSERT, function (AfterSaveEvent $event) {
			/** @var Profile $profile */
			$profile = $event->sender;

			if ($profile->gravatar_email === null) {
				$profile->gravatar_email = $profile->user->email;

				$profile->save(false);
			}
		});

		// Прописываем правильный IP адрес при создании пользователя
		Event::on(User::class, User::EVENT_AFTER_INSERT, function (Event $event) {
			/** @var User $user */
			$user = $event->sender;

			if (isset($_SERVER['HTTP_X_REAL_IP'])) {
				$user->updateAttributes(['registration_ip' => $_SERVER['HTTP_X_REAL_IP']]);
			}
		});

		// При удалении видео работы удаляем и изображение
		Event::on(Cinema::class, Cinema::EVENT_AFTER_DELETE, function (Event $event) {
			/** @var Cinema $model */
			$model = $event->sender;

			if ($model->image_id !== null) {
				Yii::$app->imageManager->deleteImage($model->image);
			}
		});

		// При удалении музыкальной работы удаляем и изображение
		Event::on(MusicWork::class, MusicWork::EVENT_AFTER_DELETE, function (Event $event) {
			/** @var MusicWork $model */
			$model = $event->sender;

			if ($model->image_id !== null) {
				Yii::$app->imageManager->deleteImage($model->image);
			}
		});

		// При удалении работы жудожника удаляем и её изображения
		Event::on(PainterWork::class, PainterWork::EVENT_AFTER_DELETE, function (Event $event) {
			/** @var PainterWork $model */
			$model = $event->sender;

			if ($model->image_id !== null) {
				Yii::$app->imageManager->deleteImage($model->image);
			}

			foreach ($model->images as $image) {
				Yii::$app->imageManager->deleteImage($image);
			}
		});
	}
}