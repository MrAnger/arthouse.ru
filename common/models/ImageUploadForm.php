<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class ImageUploadForm extends Model {
	/** @var UploadedFile */
	public $file;

	/**
	 * @var boolean
	 */
	public $isFileRequired = false;

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		$list = [];

		if ($this->isFileRequired) {
			$list[] = [['file'], 'required'];
		}

		$list[] = [['file'], 'file', 'extensions' => ['jpg', 'jpeg', 'png', 'bmp', 'gif']];

		return $list;
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'file' => 'Файл изображения',
		];
	}
}
