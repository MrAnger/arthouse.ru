<?php

namespace common\models;

use MrAnger\Yii2_ImageManager\models\Image;
use Yii;
use yii2tech\ar\position\PositionBehavior;

/**
 * This is the model class for table "{{%painter_work_images}}".
 *
 * @property string $id
 * @property string $work_id
 * @property string $image_id
 * @property string $sort_order
 *
 * @property Image $image
 * @property PainterWork $work
 */
class PainterWorkImage extends \yii\db\ActiveRecord {
	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return '{{%painter_work_images}}';
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
			'positionBehavior' => [
				'class'             => PositionBehavior::class,
				'positionAttribute' => 'sort_order',
				'groupAttributes'   => [
					'work_id',
				],
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['work_id', 'image_id'], 'required'],
			[['work_id', 'image_id', 'sort_order'], 'integer'],
			[['work_id', 'image_id'], 'unique', 'targetAttribute' => ['work_id', 'image_id']],
			[['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::class, 'targetAttribute' => ['image_id' => 'id']],
			[['work_id'], 'exist', 'skipOnError' => true, 'targetClass' => PainterWork::class, 'targetAttribute' => ['work_id' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'id'         => 'ID',
			'work_id'    => 'Работа',
			'image_id'   => 'Изображение',
			'sort_order' => 'Порядок',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getImage() {
		return $this->hasOne(Image::class, ['id' => 'image_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getWork() {
		return $this->hasOne(PainterWork::class, ['id' => 'work_id']);
	}
}
