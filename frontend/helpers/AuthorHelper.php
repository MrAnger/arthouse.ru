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
				'url'   => ['/author/news/index'],
				'code'  => 'news',
			],
		];

		foreach ($author::getWorkTypeAttributes() as $workTypeAttributeCode) {
			if ($author->{$workTypeAttributeCode}) {
				$controller = "author/" . str_replace('is_', '', $workTypeAttributeCode);

				$sectionList[] = [
					'label' => $author->getAttributeLabel($workTypeAttributeCode),
					'url'   => ["/$controller/index"],
					'code'  => $workTypeAttributeCode,
				];
			}
		}

		return $sectionList;
	}
}