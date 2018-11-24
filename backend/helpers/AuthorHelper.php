<?php

namespace backend\helpers;

use common\models\Author;

class AuthorHelper {
	/**
	 * @param Author $author
	 *
	 * @return array
	 */
	public static function getViewSections($author) {
		$sectionList = [
			[
				'label' => 'Об авторе',
				'url'   => ['/author/view', 'id' => $author->id],
				'code'  => 'base',
			],
			[
				'label' => 'Новости',
				'url'   => ['/author-news/index', 'authorId' => $author->id],
				'code'  => 'news',
			],
		];

		foreach ($author::getWorkTypeAttributes() as $workTypeAttributeCode) {
			if ($author->{$workTypeAttributeCode}) {
				$controller = "author-" . str_replace('is_', '', $workTypeAttributeCode);

				$sectionList[] = [
					'label' => $author->getAttributeLabel($workTypeAttributeCode),
					'url'   => ["/$controller/index", 'authorId' => $author->id],
					'code'  => $workTypeAttributeCode,
				];
			}
		}

		return $sectionList;
	}
}