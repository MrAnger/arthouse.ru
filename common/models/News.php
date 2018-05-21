<?php

namespace common\models;

use himiklab\sitemap\behaviors\SitemapBehavior;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%news}}".
 *
 * @property string $id
 * @property string $author_id
 * @property string $name
 * @property string $slug
 * @property string $intro
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 * @property string $archive_at
 * @property string $archived_at
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 *
 * @property Author $author
 */
class News extends \yii\db\ActiveRecord {
	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return '{{%news}}';
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
			'timestamps' => [
				'class' => TimestampBehavior::class,
				'value' => new Expression('NOW()'),
			],
			'slug'       => [
				'class'         => SluggableBehavior::class,
				'attribute'     => 'name',
				'slugAttribute' => 'slug',
				'immutable'     => true,
				'ensureUnique'  => true,
			],
			'sitemap'    => [
				'class'       => SitemapBehavior::class,
				'scope'       => function (ActiveQuery $model) {
					//$model->andWhere(['<>', 'slug', 'index']);
				},
				'dataClosure' => function (News $model) {
					return [
						'loc'        => Url::to(['/news/view-by-slug', 'slug' => $model->slug], true),
						'lastmod'    => strtotime($model->updated_at),
						'changefreq' => SitemapBehavior::CHANGEFREQ_DAILY,
						'priority'   => 0.8,
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
			[['author_id'], 'integer'],
			[['name', 'intro', 'content'], 'required'],
			[['intro', 'content'], 'string'],
			[['created_at', 'updated_at', 'archive_at', 'archived_at'], 'safe'],
			[['name'], 'string', 'max' => 250],
			[['slug', 'meta_title', 'meta_description', 'meta_keywords'], 'string', 'max' => 255],
			[['slug'], 'unique'],
			[['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Author::class, 'targetAttribute' => ['author_id' => 'id']],

			[['name', 'intro', 'content', 'slug'], 'trim'],
			[['name', 'intro', 'content', 'slug'], 'default'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'id'               => 'ID',
			'author_id'        => 'Автор',
			'name'             => 'Название',
			'slug'             => 'URL',
			'intro'            => 'Вступление',
			'content'          => 'Основной текст',
			'created_at'       => 'Создана',
			'updated_at'       => 'Изменена',
			'archive_at'       => 'Архивировать в',
			'archived_at'      => 'Архивированно в',
			'meta_title'       => 'Title',
			'meta_description' => 'Meta Description',
			'meta_keywords'    => 'Meta Keywords',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getAuthor() {
		return $this->hasOne(Author::class, ['id' => 'author_id']);
	}
}
