<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "{{%author_request}}".
 *
 * @property string $id
 * @property int $status
 * @property string $name
 * @property string $email
 * @property string $about
 * @property string $created_at
 * @property string $updated_at
 */
class AuthorRequest extends \yii\db\ActiveRecord {
	const STATUS_NEW = 0;
	const STATUS_APPROVED = 1;
	const STATUS_DECLINED = 2;

	const EVENT_NEW_REQUEST = 'eventNewAuthorRequest';

	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
			'timestamps' => [
				'class' => TimestampBehavior::class,
				'value' => new Expression('NOW()'),
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return '{{%author_request}}';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['name', 'email', 'about'], 'trim'],
			[['name', 'email', 'about'], 'default'],

			[['name', 'email', 'about'], 'required'],
			[['status'], 'integer'],
			[['about'], 'string'],
			[['created_at', 'updated_at'], 'safe'],
			[['name', 'email'], 'string', 'max' => 255],

			[['email'], 'email'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'id'         => 'ID',
			'status'     => 'Статус',
			'name'       => 'Имя и фамилия',
			'email'      => 'Email',
			'about'      => 'Краткая информация о себе',
			'created_at' => 'Дата создания',
			'updated_at' => 'Дата последнего изменения',
		];
	}

	public static function getStatusLabelList() {
		return [
			self::STATUS_NEW      => 'Новый',
			self::STATUS_APPROVED => 'Одобрен',
			self::STATUS_DECLINED => 'Отклонен',
		];
	}
}
