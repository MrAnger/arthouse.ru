<?php

namespace backend\controllers;

use common\Rbac;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\web\Controller;

/**
 * @author MrAnger
 */
abstract class BaseController extends Controller {
	/**
	 * @return array
	 */
	public function behaviors() {
		return [
			'accessControl' => [
				'class' => AccessControl::className(),
				'rules' => $this->getAccessRules(),
			],
			'verbFilter'    => [
				'class'   => VerbFilter::className(),
				'actions' => $this->getVerbs(),
			],
		];
	}

	/**
	 * Возвращает массив правил доступа. Переопределив данный метод можно дополнить или полностью заменить правила.
	 *
	 * @return array
	 */
	public function getAccessRules() {
		return [
			[
				'allow' => true,
				'roles' => [Rbac::ROLE_MASTER, Rbac::ROLE_ADMIN],
			],
		];
	}

	/**
	 * @return array
	 */
	public function getVerbs() {
		return [
			'delete' => ['POST'],
		];
	}

	/**
	 * @param array|string $params
	 * @param bool $absolute
	 * @param bool $asRouteParams
	 *
	 * @return string
	 */
	public static function getUrlToAction($params, $absolute = false, $asRouteParams = false) {
		$id = self::getControllerId();

		$params = (array)$params;

		// Проверяем формат $params[0] ( приводим actionDoSomething к do-something )
		if (substr($params[0], 0, 6) === "action")
			$params[0] = Inflector::camel2id(substr($params[0], 6, strlen($params[0]) - 6));

		$params[0] = '/' . $id . '/' . $params[0];

		if ($asRouteParams) {
			return $params;
		}

		if ($absolute)
			return Yii::$app->backendUrlManager->createAbsoluteUrl($params);
		else
			return Yii::$app->backendUrlManager->createUrl($params);
	}

	/**
	 * @return string
	 */
	public static function getControllerId() {
		$name = StringHelper::basename(static::className());

		return Inflector::camel2id(substr($name, 0, strlen($name) - 10));
	}
}