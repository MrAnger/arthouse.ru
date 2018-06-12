<?php

namespace frontend\helpers;

use common\models\Author;

class AuthorHelper {
	/**
	 * @param Author $author
	 *
	 * @return array
	 */
	public static function getViewSections(Author $author) {
		$sectionList = [
			[
				'label' => 'Новости',
				'url'   => ['/my/author/news/index'],
				'code'  => 'news',
			],
		];

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
				'label' => 'О авторе',
				'url'   => ['/author/view', 'username' => $author->user->username],
				'code'  => 'base',
			],
			[
				'label' => 'Новости',
				'url'   => ['/author-news/index', 'username' => $author->user->username],
				'code'  => 'news',
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

		return $sectionList;
	}
}