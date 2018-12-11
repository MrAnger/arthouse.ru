<?php

namespace frontend\helpers;

use common\models\Author;
use yii\helpers\Url;

class AuthorHelper {
	/**
	 * @param Author $author
	 *
	 * @return array
	 */
	public static function getViewSections(Author $author) {
		$sectionList = [];

		foreach ($author::getWorkTypeAttributes() as $workTypeAttributeCode) {
			if ($author->{$workTypeAttributeCode}) {
				$controller = "my/author/" . str_replace('is_', '', $workTypeAttributeCode);

				$sectionList[] = [
					'label' => $author->getAttributeLabel($workTypeAttributeCode),
					'url'   => ["/$controller/index"],
					'code'  => $workTypeAttributeCode,
				];
			}
		}

		$sectionList[] = [
			'label' => 'Новости',
			'url'   => ['/my/author/news/index'],
			'code'  => 'news',
		];

		return $sectionList;
	}

	/**
	 * @param Author $author
	 *
	 * @return array
	 */
	public static function getProfileViewSections($author) {
		$sectionList = [
			[
				'label' => 'Об авторе',
				'url'   => ['/author/view', 'username' => $author->user->username],
				'code'  => 'base',
			],
		];

		foreach ($author::getWorkTypeAttributes() as $workTypeAttributeCode) {
			if ($author->{$workTypeAttributeCode}) {
				$controller = "author-" . str_replace('is_', '', $workTypeAttributeCode);

				$sectionList[] = [
					'label' => $author->getAttributeLabel($workTypeAttributeCode),
					'url'   => ["/$controller/index", 'username' => $author->user->username],
					'code'  => $workTypeAttributeCode,
				];
			}
		}

		$sectionList[] = [
			'label' => 'Новости',
			'url'   => ['/author-news/index', 'username' => $author->user->username],
			'code'  => 'news',
		];

		return $sectionList;
	}

	/**
	 * @param Author $author
	 *
	 * @return string
	 */
	public static function getProfileUrl(Author $author) {
		return Url::to(['author/view', 'username' => $author->user->username]);
	}
}