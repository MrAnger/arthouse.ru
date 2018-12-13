<?php

namespace common\models\post;

use Yii;
use yii\base\Model;
use yii\helpers\Json;

class PostSectionConfig extends Model {
	/**
	 * @var string
	 */
	public $entryNameMany;

	/**
	 * @var string
	 */
	public $entryNameSingle;

	/**
	 * @var string
	 */
	public $homePageTitle;

	/**
	 * @var boolean
	 */
	public $displayOnHomePage = false;

	/**
	 * @var string
	 */
	public $otherPostsWithAuthorLabel;

	/**
	 * @var string
	 */
	public $otherPostsLabel;

	/**
	 * @var array
	 */
	public $enabledFields = [];

	/**
	 * @var array
	 */
	public $fieldLabels = [];

	/**
	 * @var array
	 */
	public $requiredFields = [];

	/**
	 * @var array
	 */
	public $previewHomePageDisplayConfig = [];

	/**
	 * @param null $json
	 * @param array $config
	 */
	public function __construct($json = null, array $config = []) {
		parent::__construct($config);

		if ($json === null) {
			$json = [];
		} else {
			$json = Json::decode($json);
		}

		foreach ($json as $attributeName => $attributeValue) {
			$this->{$attributeName} = $attributeValue;
		}
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['entryNameMany', 'entryNameSingle', 'homePageTitle', 'otherPostsWithAuthorLabel', 'otherPostsLabel', 'displayOnHomePage'], 'required'],

			[['entryNameMany', 'entryNameSingle', 'homePageTitle', 'otherPostsWithAuthorLabel', 'otherPostsLabel'], 'string', 'max' => 255],
			[['enabledFields', 'fieldLabels', 'requiredFields', 'previewHomePageDisplayConfig'], 'safe'],

			[['displayOnHomePage'], 'boolean'],

			[['entryNameMany', 'entryNameSingle', 'homePageTitle', 'otherPostsWithAuthorLabel', 'otherPostsLabel'], 'trim'],
			[['entryNameMany', 'entryNameSingle', 'homePageTitle', 'otherPostsWithAuthorLabel', 'otherPostsLabel'], 'default'],

			[['enabledFields', 'fieldLabels', 'requiredFields', 'previewHomePageDisplayConfig'], 'default', 'value' => []],

			[['fieldLabels'], 'validateFieldLabels'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'entryNameMany'                => 'Название типа работы в множественном числе',
			'entryNameSingle'              => 'Название типа работы в единственном числе',
			'homePageTitle'                => 'Названия блока на главной странице сайта',
			'displayOnHomePage'            => 'Отображать на главной странице сайта',
			'otherPostsWithAuthorLabel'    => 'Название блока других работ автора',
			'otherPostsLabel'              => 'Название блока других работ',
			'enabledFields'                => 'Включёные поля работы раздела',
			'fieldLabels'                  => 'Названия полей работы раздела',
			'requiredFields'               => 'Обязательные поля работы раздела',
			'previewHomePageDisplayConfig' => 'Настройки вывода превью работы на главной странице',
		];
	}

	/**
	 * @return string
	 */
	public function toString() {
		$output = [];

		foreach ($this->attributes as $attributeName => $attributeValue) {
			$output[$attributeName] = $attributeValue;
		}

		return Json::encode($output);
	}

	public function validateFieldLabels() {
		if (empty($this->fieldLabels)) {
			return true;
		}

		foreach ($this->fieldLabels as $fieldName => &$data) {
			foreach ($data as $key => &$label) {
				$label = trim($label);

				if (mb_strlen($label) == 0) {
					unset($data[$key]);
				}

				unset($label);
			}

			if (empty($data)) {
				unset($this->fieldLabels[$fieldName]);
			}

			unset($data);
		}
	}

	/**
	 * @return array
	 */
	public function getPostFields() {
		$fieldList = [
			'name',
			'url',
			'description',
			'text',
			'cover_image_id',
			'external_code',
			'external_url',
			'archive_at',
			'meta_title',
			'meta_description',
			'meta_keywords',
		];

		$emptyPostModel = new Post();

		$output = [];

		foreach ($fieldList as $fieldName) {
			$output[$fieldName] = $emptyPostModel->getAttributeLabel($fieldName);
		}

		$output['imageGallery'] = 'Галерея изображений';

		return $output;
	}

	/**
	 * @return array
	 */
	public function getPreviewDisplayConfigParamList() {
		return [
			'image'       => 'Изображение',
			'name'        => 'Название',
			'author'      => 'Автор',
			'description' => 'Описание',
		];
	}
}
