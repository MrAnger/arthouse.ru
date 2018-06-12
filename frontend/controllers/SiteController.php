<?php

namespace frontend\controllers;

use common\models\Block;
use common\models\Feedback;
use Yii;

/**
 * @author MrAnger
 */
class SiteController extends BaseController {
	/**
	 * @inheritdoc
	 */
	public function actions() {
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
		];
	}

	public function actionIndex() {
		return $this->render('index');
	}

	public function actionContacts() {
		$this->view->title = 'Контакты';

		$feedbackForm = new Feedback();

		$content = null;

		/** @var Block $block */
		$block = Block::findOne(['code' => 'contacts']);
		if ($block !== null) {
			$content = $block->content;
		}

		if ($feedbackForm->load(Yii::$app->request->post()) && $feedbackForm->save()) {
			Yii::$app->session->addFlash('success', 'Ваше обращение успешно отправлено.');

			return $this->refresh();
		}

		return $this->render('contacts', [
			'feedbackForm' => $feedbackForm,
			'content'      => $content,
		]);
	}
}