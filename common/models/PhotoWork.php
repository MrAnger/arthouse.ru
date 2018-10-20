<?php

namespace common\models;

use common\helpers\PhotoWorkHelper;
use himiklab\sitemap\behaviors\SitemapBehavior;
use MrAnger\Yii2_ImageManager\models\Image;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\Expression;

/**
 * This is the model class for table "{{%photo_work}}".
 *
 * @property string $id
 * @property string $author_id
 * @property string $name
 * @property string $slug
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
 * @property PainterWorkImage[] $imageLinks
 * @property ActiveQuery $images
 */
class PhotoWork extends \yii\db\ActiveRecord {
	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return '{{%photo_work}}';
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
					'targetAttribute' => ['author_id', 'name', 'slug'],
				],
			],
			'sitemap'    => [
				'class'       => SitemapBehavior::class,
				'scope'       => function (ActiveQuery $model) {
					//$model->andWhere(['<>', 'slug', 'index']);
				},
				'dataClosure' => function (PainterWork $model) {
					return [
						'loc'        => PhotoWorkHelper::getPhotoWorkFrontendUrl($model),
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
			[['author_id', 'name', 'slug'], 'required'],
			[['author_id', 'image_id'], 'integer'],
			[['description'], 'string'],
			[['created_at', 'updated_at'], 'safe'],
			[['name'], 'string', 'max' => 250],
			[['slug', 'meta_title', 'meta_description', 'meta_keywords'], 'string', 'max' => 255],
			[['image_url'], 'string', 'max' => 1500],
			[['author_id', 'name'], 'unique', 'targetAttribute' => ['author_id', 'name']],
			[['author_id', 'slug'], 'unique', 'targetAttribute' => ['author_id', 'slug']],
			[['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Author::class, 'targetAttribute' => ['author_id' => 'id']],
			[['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::class, 'targetAttribute' => ['image_id' => 'id']],

			[['name', 'description', 'slug', 'image_url', 'meta_title', 'meta_description', 'meta_keywords'], 'trim'],
			[['name', 'description', 'slug', 'image_url', 'meta_title', 'meta_description', 'meta_keywords'], 'default'],

			[['slug'], 'match', 'pattern' => '/^[\w\-_]*$/i'],
			[['image_url'], 'url'],
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
	 * @return \yii\db\ActiveQuery
	 */
	public function getImageLinks() {
		return $this->hasMany(PainterWorkImage::class, ['work_id' => 'id'])
			->orderBy(['sort_order' => SORT_ASC]);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getImages() {
		return Image::find()
			->leftJoin(PhotoWorkImage::tableName(), Image::tableName() . ".id = " . PhotoWorkImage::tableName() . ".image_id")
			->where([PhotoWorkImage::tableName() . ".work_id" => $this->id])
			->orderBy([PhotoWorkImage::tableName() . ".sort_order" => SORT_ASC]);

		/*return $this->hasMany(Image::class, ['id' => 'image_id'])
			->viaTable(PainterWorkImage::tableName(), ['work_id' => 'id']);*/
	}
}
