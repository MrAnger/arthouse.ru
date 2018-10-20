<?php

namespace common\models;

use MrAnger\Yii2_ImageManager\models\Image;
use Yii;

/**
 * @property integer $avatar_image_id
 *
 * @property Image $avatarImage
 */
class Profile extends \Da\User\Model\Profile {
	public function rules() {
		return array_merge(parent::rules(), [
			[['avatar_image_id'], 'integer'],
			[['avatar_image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::class, 'targetAttribute' => ['avatar_image_id' => 'id']],

			[['name', 'public_email', 'gravatar_email', 'location', 'website'], 'trim'],
			[['name', 'public_email', 'gravatar_email', 'location', 'website'], 'default'],
		]);
	}

	public function attributeLabels() {
		return array_merge(parent::attributeLabels(), [
			'avatar_image_id' => 'Аватар',
		]);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getAvatarImage() {
		return $this->hasOne(Image::class, ['id' => 'avatar_image_id']);
	}
} 