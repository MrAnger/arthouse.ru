<?php

namespace common\models\post;

use himiklab\sitemap\behaviors\SitemapBehavior;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveQuery;
use yii2tech\ar\position\PositionBehavior;

/**
 * This is the model class for table "{{%post_section}}".
 *
 * @property string $id ID
 * @property string $name Название
 * @property string $url URL
 * @property integer $is_enabled Включён
 * @property string $config Конфиг
 * @property integer $sort Порядковый номер
 *
 * @property Post[] $posts
 * @property PostSectionUserRight[] $postSectionUserRights
 */
class PostSection extends \yii\db\ActiveRecord {
	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return '{{%post_section}}';
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
			'slug'             => [
				'class'         => SluggableBehavior::className(),
				'attribute'     => 'name',
				'slugAttribute' => 'url',
				'immutable'     => true,
				'ensureUnique'  => true,
			],
			'positionBehavior' => [
				'class'             => PositionBehavior::className(),
				'positionAttribute' => 'order',
			],
			'sitemap'          => [
				'class'       => SitemapBehavior::className(),
				'scope'       => function (ActiveQuery $model) {
					$model->andWhere(['=', 'is_enabled', 1]);
				},
				'dataClosure' => function (PostSection $model) {
					return [
						//'loc'        => NewsHelper::getNewsFrontendUrl($model),
						'loc'        => 'link',
						//'lastmod'    => strtotime($model->updated_at),
						'lastmod'    => 'datetime',
						'changefreq' => SitemapBehavior::CHANGEFREQ_DAILY,
						'priority'   => 0.5,
					];
				},
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['name'], 'required'],

			[['config'], 'string'],
			[['name'], 'string', 'max' => 250],
			[['url'], 'string', 'max' => 255],
			[['is_enabled'], 'boolean'],
			[['sort'], 'integer'],

			[['name'], 'unique'],
			[['url'], 'unique'],

			[['url'], 'match', 'pattern' => '/^[\w\-_]*$/i'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'id'         => 'ID',
			'name'       => 'Название',
			'url'        => 'URL',
			'is_enabled' => 'Включён',
			'config'     => 'Конфиг',
			'sort'       => 'Порядковый номер',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getPosts() {
		return $this->hasMany(Post::className(), ['section_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getPostSectionUserRights() {
		return $this->hasMany(PostSectionUserRight::className(), ['post_section_id' => 'id']);
	}

	/**
	 * @return PostSectionConfig
	 */
	public function getConfigModel() {
		return new PostSectionConfig($this->config);
	}

	public function setConfigModel(PostSectionConfig $configModel) {
		$this->config = $configModel->toString();
	}
}
