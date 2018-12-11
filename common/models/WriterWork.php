<?php

namespace common\models;

use common\helpers\WriterWorkHelper;
use himiklab\sitemap\behaviors\SitemapBehavior;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\Expression;

/**
 * This is the model class for table "{{%writer_work}}".
 *
 * @property string $id
 * @property string $author_id
 * @property string $name
 * @property string $slug
 * @property string $intro
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 *
 * @property Author $author
 */
class WriterWork extends \yii\db\ActiveRecord {
	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return '{{%writer_work}}';
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
				'class'           => SluggableBehavior::class,
				'attribute'       => 'name',
				'slugAttribute'   => 'slug',
				'immutable'       => true,
				'ensureUnique'    => true,
				'uniqueValidator' => [
					'targetAttribute' => ['author_id', 'slug'],
				],
			],
			'sitemap'    => [
				'class'       => SitemapBehavior::class,
				'scope'       => function (ActiveQuery $model) {
					//$model->andWhere(['<>', 'slug', 'index']);
				},
				'dataClosure' => function (WriterWork $model) {
					return [
						'loc'        => WriterWorkHelper::getWriterWorkFrontendUrl($model),
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
			[['name', 'content'], 'required'],
			[['intro', 'content'], 'string'],
			[['created_at', 'updated_at'], 'safe'],
			[['name'], 'string', 'max' => 250],
			[['slug', 'meta_title', 'meta_description', 'meta_keywords'], 'string', 'max' => 255],
			[['author_id', 'slug'], 'unique', 'targetAttribute' => ['author_id', 'slug']],
			[['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Author::class, 'targetAttribute' => ['author_id' => 'id']],

			[['name', 'intro', 'content', 'slug', 'meta_title', 'meta_description', 'meta_keywords'], 'trim'],
			[['name', 'intro', 'content', 'slug', 'meta_title', 'meta_description', 'meta_keywords'], 'default'],

			[['slug'], 'match', 'pattern' => '/^[\w\-_]*$/i'],
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
			'created_at'       => 'Создано',
			'updated_at'       => 'Изменено',
			'meta_title'       => 'Meta Title',
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

	/**
	 * @return WriterWork
	 */
	public function getNext() {
		return self::find()
			->where([
				'author_id' => $this->author_id,
			])
			->andWhere(['<', 'created_at', $this->created_at])
			->orderBy(['created_at' => SORT_DESC])
			->one();
	}

	/**
	 * @return WriterWork
	 */
	public function getPrev() {
		return self::find()
			->where([
				'author_id' => $this->author_id,
			])
			->andWhere(['>', 'created_at', $this->created_at])
			->orderBy(['created_at' => SORT_ASC])
			->one();
	}

	/**
	 * @param integer $count
	 *
	 * @return WriterWork[]
	 */
	public function getSimilarAuthorWorkList($count = 5) {
		return self::find()
			->where([
				'author_id' => $this->author_id,
			])
			->andWhere(['<>', 'id', $this->id])
			->orderBy(new Expression('RAND()'))
			->limit(5)
			->all();
	}

	/**
	 * @param integer $count
	 *
	 * @return WriterWork[]
	 */
	public function getSimilarWorkList($count = 5) {
		return self::find()
			->andWhere(['<>', 'author_id', $this->author_id])
			->orderBy(new Expression('RAND()'))
			->limit(5)
			->all();
	}
}
