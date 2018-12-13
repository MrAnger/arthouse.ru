<?php

namespace common\components;

use common\models\post\PostSection;
use Yii;
use yii\base\Component;

class PostManager extends Component {
	/**
	 * @param PostSection $section
	 *
	 * @return string
	 */
	public function getSectionFrontendUrl(PostSection $section) {
		return Yii::$app->frontendUrlManager->createAbsoluteUrl($section->url);
	}
}
