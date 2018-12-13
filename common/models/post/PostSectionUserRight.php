<?php

namespace common\models\post;

use common\models\User;
use Yii;

/**
 * This is the model class for table "{{%post_section_user_right}}".
 *
 * @property int $user_id Автор
 * @property string $post_section_id Раздел
 *
 * @property PostSection $postSection
 * @property User $user
 */
class PostSectionUserRight extends \yii\db\ActiveRecord {
	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return '{{%post_section_user_right}}';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['user_id', 'post_section_id'], 'required'],

			[['user_id', 'post_section_id'], 'integer'],
			[['user_id', 'post_section_id'], 'unique', 'targetAttribute' => ['user_id', 'post_section_id']],

			[['post_section_id'], 'exist', 'skipOnError' => true, 'targetClass' => PostSection::className(), 'targetAttribute' => ['post_section_id' => 'id']],
			[['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'user_id'         => 'Автор',
			'post_section_id' => 'Раздел',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getPostSection() {
		return $this->hasOne(PostSection::className(), ['id' => 'post_section_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUser() {
		return $this->hasOne(User::className(), ['id' => 'user_id']);
	}
}
