<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%author}}".
 *
 * @property string $id
 * @property int $user_id
 * @property int $is_painter
 * @property int $is_cinematographer
 * @property int $is_writer
 * @property int $is_musician
 * @property int $is_photo
 * @property int $is_theater
 *
 * @property User $user
 */
class Author extends \yii\db\ActiveRecord {
	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return '{{%author}}';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['user_id'], 'required'],
			[['user_id', 'is_painter', 'is_cinematographer', 'is_writer', 'is_musician', 'is_photo', 'is_theater'], 'integer'],
			[['user_id'], 'unique'],
			[['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'id'                 => 'ID',
			'user_id'            => 'Пользователь',
			'is_painter'         => 'Арт-студия',
			'is_cinematographer' => 'Кино',
			'is_writer'          => 'Литература',
			'is_musician'        => 'Музыка',
			'is_photo'           => 'Фотография',
			'is_theater'         => 'Театр',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUser() {
		return $this->hasOne(User::class, ['id' => 'user_id']);
	}

	/**
	 * @return array
	 */
	public static function getWorkTypeAttributes() {
		return [
			'is_writer',
			'is_painter',
			'is_photo',
			'is_musician',
			'is_cinematographer',
			'is_theater',
		];
	}
}
