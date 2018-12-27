<?php

namespace frontend\controllers;

use common\models\AuthorRequest;
use common\models\Block;
use common\models\Cinema;
use common\models\Feedback;
use common\models\MusicWork;
use common\models\News;
use common\models\PainterWork;
use common\models\PhotoWork;
use common\models\Theater;
use common\models\WriterWork;
use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

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
		$aboutContent = null;

		/** @var Block $aboutBlock */
		$aboutBlock = Block::findOne(['code' => 'main_page_about']);
		if ($aboutBlock !== null) {
			$aboutContent = $aboutBlock->content;
		}

		$countLastWorks = ArrayHelper::getValue(Yii::$app->params, 'homePage.countLastWorks', 3);

		$lastWorkList = [
			[
				'name'  => 'Литература',
				'url'   => ['writer/index'],
				'items' => WriterWork::find()
					->joinWith(['author.user.profile'])
					->orderBy(['created_at' => SORT_DESC])
					->limit($countLastWorks)
					->all(),
			],
			[
				'name'  => 'Арт-студия',
				'url'   => ['painter/index'],
				'items' => PainterWork::find()
					->joinWith(['author.user.profile'])
					->orderBy(['created_at' => SORT_DESC])
					->limit($countLastWorks)
					->all(),
			],
			[
				'name'  => 'Фотография',
				'url'   => ['photo/index'],
				'items' => PhotoWork::find()
					->joinWith(['author.user.profile'])
					->orderBy(['created_at' => SORT_DESC])
					->limit($countLastWorks)
					->all(),
			],
			[
				'name'  => 'Музыка',
				'url'   => ['musician/index'],
				'items' => MusicWork::find()
					->joinWith(['author.user.profile'])
					->orderBy(['created_at' => SORT_DESC])
					->limit($countLastWorks)
					->all(),
			],
			[
				'name'  => 'Кино',
				'url'   => ['cinematographer/index'],
				'items' => Cinema::find()
					->joinWith(['author.user.profile'])
					->orderBy(['created_at' => SORT_DESC])
					->limit($countLastWorks)
					->all(),
			],
			[
				'name'  => 'Театр',
				'url'   => ['theater/index'],
				'items' => Theater::find()
					->joinWith(['author.user.profile'])
					->orderBy(['created_at' => SORT_DESC])
					->limit($countLastWorks)
					->all(),
			],
		];
		foreach ($lastWorkList as $index => $item) {
			if (empty($item['items'])) {
				unset($lastWorkList[$index]);
			}
		}

		$newsList = News::find()
			->joinWith(['author.user.profile'])
			->where([
				'AND',
				new Expression('archived_at IS NULL'),
			])
			->orderBy(['created_at' => SORT_DESC])
			->limit($countLastWorks)
			->all();

		$this->view->title = implode(' - ', [
			'Каталог работ творческих людей',
			Yii::$app->name,
		]);

		return $this->render('index', [
			'aboutContent' => $aboutContent,
			'lastWorkList' => $lastWorkList,
			'newsList'     => $newsList,
		]);
	}

	public function actionContacts() {
		$this->view->title = 'Контакты';

		$feedbackForm = new Feedback();
		$requestForm = new AuthorRequest();

		$content = null;

		/** @var Block $block */
		$block = Block::findOne(['code' => 'contacts']);
		if ($block !== null) {
			$content = $block->content;
		}

		if ($feedbackForm->load(Yii::$app->request->post()) && $feedbackForm->save()) {
			Yii::$app->session->addFlash('success', 'Ваше обращение успешно отправлено.');

			$feedbackForm->trigger($feedbackForm::EVENT_NEW_FEEDBACK);

			return $this->refresh();
		}

		if ($requestForm->load(Yii::$app->request->post()) && $requestForm->save()) {
			Yii::$app->session->addFlash('success', 'Ваша заявка успешно отправлена.');

			$requestForm->trigger($requestForm::EVENT_NEW_REQUEST);

			return $this->refresh();
		}

		$this->view->title = implode(' - ', [
			'Контакты',
			Yii::$app->name,
		]);

		return $this->render('contacts', [
			'feedbackForm' => $feedbackForm,
			'requestForm'  => $requestForm,
			'content'      => $content,
		]);
	}
}