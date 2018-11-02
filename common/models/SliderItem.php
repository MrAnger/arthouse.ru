<?php

namespace common\models;

use MrAnger\Yii2_ImageManager\models\Image;
use Yii;
use yii2tech\ar\position\PositionBehavior;

/**
 * This is the model class for table "{{%slider_item}}".
 *
 * @property string $id ID
 * @property string $slider_id Слайдер
 * @property string $image_id Изображение
 * @property string $name Название
 * @property string $description Описание
 * @property int $is_enabled Включён
 * @property int $order Порядок
 *
 * @property Slider $slider
 * @property Image $image
 */
class SliderItem extends \yii\db\ActiveRecord {
	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return '{{%slider_item}}';
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
			'positionBehavior' => [
				'class'             => PositionBehavior::class,
				'positionAttribute' => 'order',
				'groupAttributes'   => [
					'slider_id',
				],
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['slider_id', 'name'], 'required'],
			[['slider_id', 'image_id', 'is_enabled', 'order'], 'integer'],
			[['description'], 'string'],
			[['name'], 'string', 'max' => 255],
			[['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['image_id' => 'id']],
			[['slider_id'], 'exist', 'skipOnError' => true, 'targetClass' => Slider::className(), 'targetAttribute' => ['slider_id' => 'id']],

			[['is_enabled'], 'boolean'],

			[['name', 'description'], 'trim'],
			[['name', 'description'], 'default'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'id'          => 'ID',
			'slider_id'   => 'Слайдер',
			'image_id'    => 'Изображение',
			'name'        => 'Название',
			'description' => 'Описание',
			'is_enabled'  => 'Включён',
			'order'       => 'Порядок',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getSlider() {
		return $this->hasOne(Slider::className(), ['id' => 'slider_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getImage() {
		return $this->hasOne(Image::className(), ['id' => 'image_id']);
	}
}
