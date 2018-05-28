<?php

namespace console\controllers;

use common\models\News;
use Yii;
use yii\console\Controller;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * @author MrAnger
 */
class UtilsController extends Controller {
	public function actionNewsArchive() {
		// Сначала проходим по новостям, у которых не настроена дата архивации
		$query = News::find()
			->where([
				'AND',
				new Expression("archived_at IS NULL"),
				new Expression("archive_at IS NULL"),
				['>=', new Expression("DATEDIFF(NOW(), created_at)"), ArrayHelper::getValue(Yii::$app->params, 'countDaysForMoveNewsToArchive', 7)],
			]);

		foreach ($query->batch() as $batch) {
			/** @var News $news */
			foreach ($batch as $news) {
				$news->updateAttributes(['archived_at' => new Expression('NOW()')]);

				$this->stdout("News[ID: $news->id] archived successfully." . PHP_EOL);
			}
		}

		// Теперь проходим по новостям, у которых настроена дата архивации
		$query = News::find()
			->where([
				'AND',
				new Expression("archived_at IS NULL"),
				new Expression("archive_at IS NOT NULL"),
				['>=', new Expression('NOW()'), new Expression('archive_at')],
			]);

		//echo $query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql;exit;

		foreach ($query->batch() as $batch) {
			/** @var News $news */
			foreach ($batch as $news) {
				$news->updateAttributes(['archived_at' => new Expression('NOW()')]);

				$this->stdout("News[ID: $news->id] archived successfully." . PHP_EOL);
			}
		}
	}
}