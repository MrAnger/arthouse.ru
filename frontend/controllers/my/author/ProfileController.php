<?php

namespace frontend\controllers\my\author;

use backend\helpers\AuthorHelper;
use backend\models\NewsSearch;
use common\models\Author;
use common\models\ImageUploadForm;
use common\models\News;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * @author MrAnger
 */
class ProfileController extends BaseController {
	public function actionUploadAvatar() {
		Yii::$app->response->format = Response::FORMAT_JSON;

		/** @var User $user */
		$user = Yii::$app->user->identity;
		$profile = $user->profile;

		$imageManager = Yii::$app->imageManager;
		$imageUploadForm = new ImageUploadForm();

		$imageUploadForm->load(Yii::$app->request->post());

		$imageUploadForm->file = UploadedFile::getInstance($imageUploadForm, 'file');

		if ($imageUploadForm->validate() && $imageUploadForm->file !== null) {
			$imageEntry = $imageManager->upload($imageUploadForm->file);

			$profile->updateAttributes(['avatar_image_id' => $imageEntry->id]);
		} else {
			Yii::$app->session->addFlash('warning', $imageUploadForm->getFirstError('file'));
		}

		return true;
	}
}
