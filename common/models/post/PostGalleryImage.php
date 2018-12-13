<?php

namespace common\models\post;

use MrAnger\Yii2_ImageManager\models\Image;
use Yii;
use yii2tech\ar\position\PositionBehavior;

/**
 * This is the model class for table "{{%post_gallery_images}}".
 *
 * @property string $post_id Пост
 * @property string $image_id Изображение
 * @property string $order Порядковый номер
 *
 * @property Image $image
 * @property Post $post
 */
class PostGalleryImage extends \yii\db\ActiveRecord {
	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return '{{%post_gallery_images}}';
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
			'positionBehavior' => [
				'class'             => PositionBehavior::className(),
				'positionAttribute' => 'order',
				'groupAttributes'   => [
					'post_id',
				],
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['post_id', 'image_id'], 'required'],

			[['post_id', 'image_id', 'order'], 'integer'],
			[['post_id', 'image_id'], 'unique', 'targetAttribute' => ['post_id', 'image_id']],

			[['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['image_id' => 'id']],
			[['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'post_id'  => 'Пост',
			'image_id' => 'Изображение',
			'order'    => 'Порядковый номер',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getImage() {
		return $this->hasOne(Image::className(), ['id' => 'image_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getPost() {
		return $this->hasOne(Post::className(), ['id' => 'post_id']);
	}
}
