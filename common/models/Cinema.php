<?php

namespace common\models;

use common\helpers\CinemaHelper;
use himiklab\sitemap\behaviors\SitemapBehavior;
use MrAnger\Yii2_ImageManager\models\Image;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\Expression;

/**
 * This is the model class for table "{{%cinema}}".
 *
 * @property string $id
 * @property string $author_id
 * @property string $name
 * @property string $slug
 * @property string $video_url
 * @property string $video_code
 * @property string $image_url
 * @property string $image_id
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 *
 * @property Author $author
 * @property Image $image
 */
class Cinema extends \yii\db\ActiveRecord {
	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return '{{%cinema}}';
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
				'dataClosure' => function (News $model) {
					return [
						'loc'        => CinemaHelper::getCinemaFrontendUrl($model),
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
			[['author_id', 'name', 'video_url'], 'required'],
			[['author_id', 'image_id'], 'integer'],
			[['description'], 'string'],
			[['created_at', 'updated_at'], 'safe'],
			[['name'], 'string', 'max' => 250],
			[['slug', 'meta_title', 'meta_description', 'meta_keywords'], 'string', 'max' => 255],
			[['video_url', 'image_url'], 'string', 'max' => 1500],
			[['video_code'], 'string', 'max' => 2000],
			[['author_id', 'slug'], 'unique', 'targetAttribute' => ['author_id', 'slug']],
			[['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Author::class, 'targetAttribute' => ['author_id' => 'id']],
			[['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::class, 'targetAttribute' => ['image_id' => 'id']],

			[['name', 'description', 'slug', 'video_url', 'video_code', 'image_url', 'meta_title', 'meta_description', 'meta_keywords'], 'trim'],
			[['name', 'description', 'slug', 'video_url', 'video_code', 'image_url', 'meta_title', 'meta_description', 'meta_keywords'], 'default'],

			[['slug'], 'match', 'pattern' => '/^[\w\-_]*$/i'],
			[['video_url', 'image_url'], 'url'],
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
			'video_url'        => 'Ссылка на видео',
			'video_code'       => 'Код встраивания видео',
			'image_url'        => 'Ссылка на изображение',
			'image_id'         => 'Изображение',
			'description'      => 'Описание',
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
	 * @return \yii\db\ActiveQuery
	 */
	public function getImage() {
		return $this->hasOne(Image::class, ['id' => 'image_id']);
	}

	/**
	 * @return Cinema
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
	 * @return Cinema
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
	 * @return Cinema[]
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
	 * @return Cinema[]
	 */
	public function getSimilarWorkList($count = 5) {
		return self::find()
			->andWhere(['<>', 'author_id', $this->author_id])
			->orderBy(new Expression('RAND()'))
			->limit(5)
			->all();
	}
}
