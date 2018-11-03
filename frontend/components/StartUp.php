<?php

namespace frontend\components;

use common\helpers\MailHelper;
use common\models\AuthorRequest;
use common\models\Feedback;
use Yii;
use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\base\ModelEvent;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

/**
 * @author MrAnger
 */
class StartUp implements BootstrapInterface {
	/**
	 * @inheritDoc
	 */
	public function bootstrap($app) {
		// После создания заявки отправляем email уведомление администратору
		Event::on(AuthorRequest::class, AuthorRequest::EVENT_NEW_REQUEST, function (Event $event) {
			/** @var AuthorRequest $request */
			$request = $event->sender;

			$notificationEmail = ArrayHelper::getValue(Yii::$app->params, 'authorRequestNotificationEmail');

			if ($notificationEmail === null) {
				return true;
			}

			try {
				MailHelper::sendMailWithText(null, $notificationEmail, 'Новая заявка в авторы на сайте ArtHouse.Ru',
					"Была получена заявка от $request->name($request->email)."
				);
			} catch (\Exception $e) {
				$errorCode = $e->getCode();
				$errorMessage = $e->getMessage();

				Yii::error("Error on sending email notification of new request to authors. Error[$errorCode]: $errorMessage\r\n" . $e->getTraceAsString());
			}
		});

		// После создания обращения через форму обратной связи отправляем email уведомление администратору
		Event::on(Feedback::class, Feedback::EVENT_NEW_FEEDBACK, function (Event $event) {
			/** @var Feedback $feedback */
			$feedback = $event->sender;

			$notificationEmail = ArrayHelper::getValue(Yii::$app->params, 'authorRequestNotificationEmail');

			if ($notificationEmail === null) {
				return true;
			}

			try {
				MailHelper::sendMailWithText(null, $notificationEmail, 'Новая обращение через форму обратной связи на сайте ArtHouse.Ru',
					"Было получено новое обращение от $feedback->name($feedback->email)."
				);
			} catch (\Exception $e) {
				$errorCode = $e->getCode();
				$errorMessage = $e->getMessage();

				Yii::error("Error on sending email notification of new feedback. Error[$errorCode]: $errorMessage\r\n" . $e->getTraceAsString());
			}
		});
	}
}