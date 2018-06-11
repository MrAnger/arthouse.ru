<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "{{%feedback}}".
 *
 * @property string $id
 * @property int $status
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $text
 * @property string $created_at
 */
class Feedback extends \yii\db\ActiveRecord {
	const STATUS_NEW = 0;
	const STATUS_VIEWED = 1;

	const EVENT_NEW_FEEDBACK = 'eventNewFeedback';

	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
			'timestamps' => [
				'class'              => TimestampBehavior::class,
				'value'              => new Expression('NOW()'),
				'updatedAtAttribute' => false,
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return '{{%feedback}}';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['status'], 'integer'],
			[['name', 'email'], 'required'],
			[['text'], 'string'],
			[['name', 'email', 'phone'], 'string', 'max' => 255],
			[['created_at'], 'safe'],

			[['email'], 'email'],
			[['phone'], 'match', 'pattern' => '/^\+7 \d{3} \d{3}\-\d{2}\-\d{2}$/i'],

			[['name', 'email', 'phone', 'text'], 'trim'],
			[['name', 'email', 'phone', 'text'], 'default'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'id'         => 'ID',
			'status'     => 'Статус',
			'name'       => 'Имя',
			'email'      => 'Email',
			'phone'      => 'Телефон',
			'text'       => 'Сообщение',
			'created_at' => 'Создано',
		];
	}

	public static function getStatusLabelList() {
		return [
			self::STATUS_NEW    => 'Новый',
			self::STATUS_VIEWED => 'Просмотрен',
		];
	}
}
