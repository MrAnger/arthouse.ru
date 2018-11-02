<?php

namespace common\models;

use Yii;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "{{%slider}}".
 *
 * @property string $id ID
 * @property string $name Название
 * @property string $code Код
 * @property int $is_enabled Включён
 *
 * @property SliderItem[] $items
 */
class Slider extends \yii\db\ActiveRecord {
	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return '{{%slider}}';
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
			'slug' => [
				'class'         => SluggableBehavior::class,
				'attribute'     => 'name',
				'slugAttribute' => 'code',
				'immutable'     => true,
				'ensureUnique'  => true,
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['name', 'code'], 'required'],
			[['is_enabled'], 'integer'],
			[['name'], 'string', 'max' => 250],
			[['code'], 'string', 'max' => 255],
			[['code'], 'unique'],

			[['is_enabled'], 'boolean'],

			[['name', 'code'], 'trim'],
			[['name', 'code'], 'default'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'id'         => 'ID',
			'name'       => 'Название',
			'code'       => 'Код',
			'is_enabled' => 'Включён',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getItems() {
		return $this->hasMany(SliderItem::className(), ['slider_id' => 'id'])
			->orderBy(['order' => SORT_ASC]);
	}
}
