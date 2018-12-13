<?php

namespace common\models\post;

use common\models\User;
use himiklab\sitemap\behaviors\SitemapBehavior;
use MrAnger\Yii2_ImageManager\models\Image;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\Expression;

/**
 * This is the model class for table "{{%post}}".
 *
 * @property string $id ID
 * @property string $section_id Раздел
 * @property int $user_id Автор
 * @property string $name Название
 * @property string $url URL
 * @property string $description Описание
 * @property string $text Текст
 * @property string $cover_image_id Изображение
 * @property string $external_code Внешний код встраивания
 * @property string $external_url Внешняя ссылка
 * @property string $archive_at Дата архивации
 * @property string $archived_at Архивирован
 * @property string $meta_title Title
 * @property string $meta_description Мета описание
 * @property string $meta_keywords Мета ключевые слова
 * @property string $created_at Дата создания
 * @property string $updated_at Дата последнего изменения
 *
 * @property PostSection $section
 * @property User $user
 * @property PostGalleryImage[] $galleryImageLinks
 * @property Image[] $galleryImages
 */
class Post extends \yii\db\ActiveRecord {
	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return '{{%post}}';
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
			'timestamps' => [
				'class' => TimestampBehavior::className(),
				'value' => new Expression('NOW()'),
			],
			'slug'       => [
				'class'           => SluggableBehavior::className(),
				'attribute'       => 'name',
				'slugAttribute'   => 'url',
				'immutable'       => true,
				'ensureUnique'    => true,
				'uniqueValidator' => [
					'targetAttribute' => ['section_id', 'author_id', 'url'],
				],
			],
			'sitemap'    => [
				'class'       => SitemapBehavior::className(),
				'scope'       => function (ActiveQuery $model) {
					//$model->andWhere(['<>', 'slug', 'index']);
				},
				'dataClosure' => function (Post $model) {
					return [
						//'loc'        => NewsHelper::getNewsFrontendUrl($model),
						'loc'        => 'link',
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
			[['section_id', 'name'], 'required'],

			[['section_id', 'user_id', 'cover_image_id'], 'integer'],
			[['text'], 'string'],
			[['archive_at', 'archived_at', 'created_at', 'updated_at'], 'safe'],
			[['name'], 'string', 'max' => 1020],
			[['url', 'meta_title'], 'string', 'max' => 1024],
			[['description', 'external_code', 'external_url', 'meta_description', 'meta_keywords'], 'string', 'max' => 2048],

			[['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => PostSection::className(), 'targetAttribute' => ['section_id' => 'id']],
			[['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],

			[['name', 'description', 'text', 'url', 'external_code', 'external_url', 'archive_at', 'meta_title', 'meta_description', 'meta_keywords'], 'trim'],
			[['name', 'description', 'text', 'url', 'external_code', 'external_url', 'archive_at', 'meta_title', 'meta_description', 'meta_keywords'], 'default'],

			[['url'], 'match', 'pattern' => '/^[\w\-_]*$/i'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'id'               => 'ID',
			'section_id'       => 'Раздел',
			'user_id'          => 'Автор',
			'name'             => 'Название',
			'url'              => 'URL',
			'description'      => 'Описание',
			'text'             => 'Текст',
			'cover_image_id'   => 'Изображение',
			'external_code'    => 'Внешний код встраивания',
			'external_url'     => 'Внешняя ссылка',
			'archive_at'       => 'Дата архивации',
			'archived_at'      => 'Архивирован',
			'meta_title'       => 'Title',
			'meta_description' => 'Мета описание',
			'meta_keywords'    => 'Мета ключевые слова',
			'created_at'       => 'Дата создания',
			'updated_at'       => 'Дата последнего изменения',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getSection() {
		return $this->hasOne(PostSection::className(), ['id' => 'section_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUser() {
		return $this->hasOne(User::className(), ['id' => 'user_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getGalleryImageLinks() {
		return $this->hasMany(PostGalleryImage::className(), ['post_id' => 'id'])
			->joinWith('image')
			->orderBy(['order' => SORT_ASC]);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getGalleryImages() {
		return $this->hasMany(Image::className(), ['id' => 'image_id'])
			->viaTable(PostGalleryImage::tableName(), ['post_id' => 'id'])
			->orderBy(['order' => SORT_ASC]);
	}
}
