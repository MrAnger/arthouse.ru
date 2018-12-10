<?php

namespace common\components;

use Imagine\Image\Box;
use MrAnger\Yii2_ImageManager\models\Image;
use sadovojav\image\Thumbnail;
use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * @author MrAnger
 */
class ImageManager extends \MrAnger\Yii2_ImageManager\ImageManager {
	/**
	 * @param Image|integer $image
	 *
	 * @return string
	 */
	public function getOriginalUrl($image) {
		$url = parent::getOriginalUrl($image);

		return Yii::$app->frontendUrlManager->createAbsoluteUrl($url, true);
	}

	/**
	 * @param Image $image
	 * @param string $presetId
	 *
	 * @return string
	 */
	public function getThumbnailUrl($image, $presetId = 'default') {
		$url = parent::getThumbnailUrl($image, $presetId);

		return Yii::$app->frontendUrlManager->createAbsoluteUrl($this->fixThumbnailUrl($url), true);
	}

	/**
	 * @param string $file
	 * @param string|array $presetId
	 *
	 * @return string
	 *
	 * @throws
	 */
	public function getThumbnailUrlByFile($file, $presetId = 'default') {
		$file = Yii::getAlias($file);

		if (!file_exists($file)) {
			return null;
		}

		/** @var Thumbnail $thumbnailSystem */
		$thumbnailSystem = Yii::$app->get('thumbnail');

		/** @var Thumbnail $thumbnailTemp */
		$thumbnailTemp = Yii::createObject([
			'class'     => Thumbnail::className(),
			'basePath'  => dirname($file),
			'cachePath' => $thumbnailSystem->cachePath,
		]);

		$url = $thumbnailTemp->url(basename($file), $this->getPresetDefinition($presetId));

		return Yii::$app->frontendUrlManager->createAbsoluteUrl($this->fixThumbnailUrl($url), true);
	}

	/**
	 * @param integer[] $imageIdList
	 *
	 * @return array
	 */
	public function getOriginalBucket($imageIdList) {
		$output = parent::getOriginalBucket($imageIdList);

		foreach ($output as &$url) {
			$url = Yii::$app->frontendUrlManager->createAbsoluteUrl($url, true);

			unset($url);
		}

		return $output;
	}

	public function getThumbnailBucket($imageIdList, $presetList) {
		$output = parent::getThumbnailBucket($imageIdList, $presetList);

		foreach ($output as $imageId => &$data) {
			foreach ($data as $presetId => &$url) {
				$url = $this->fixThumbnailUrl($url);

				unset($url);
			}

			unset($data);
		}

		return $output;
	}

	/**
	 * @inheritdoc
	 */
	public function upload(UploadedFile $file, $deleteTempFile = true) {
		// Пережимаем исходное изображение
		$compressedFilePath = self::compressImage($file);

		if ($compressedFilePath !== false) {
			if ($deleteTempFile) {
				@unlink($file->tempName);
			}

			$model = $this->createImage(basename($compressedFilePath));

			$filePath = $this->uploadPath . $model->file;
			$fileInfo = pathinfo($filePath);

			if (!is_dir($fileInfo['dirname'])) {
				FileHelper::createDirectory($fileInfo['dirname']);
			}

			$result = copy($compressedFilePath, $filePath);

			if ($deleteTempFile) {
				@unlink($compressedFilePath);
			}

			if (!$result) {
				throw new \Exception("Failed to save image '$filePath'. Perhaps the file size limit exceeded. Also you can check whether the target directory has necessary permissions.");
			}

			if (!$model->save()) {
				Yii::error("Failed to save image model instance.");
			}

			return $model;
		}

		return parent::upload($file, $deleteTempFile);
	}

	/**
	 * @param UploadedFile $file
	 * @param integer $maxWidth
	 * @param integer $maxHeight
	 *
	 * @return string
	 *
	 * @throws
	 */
	public static function compressImage(UploadedFile $file, $maxWidth = 1920, $maxHeight = 1080) {
		$fileInfo = pathinfo($file->name);

		$imageData = getimagesize($file->tempName);
		$width = $imageData[0];
		$height = $imageData[1];
		$ratio = $width / $height;

		$newImagePath = Yii::getAlias(Yii::$app->imageManager->uploadPath) . uniqid("compressed-") . '-' . md5(uniqid() . $fileInfo['basename']) . '.' . $fileInfo['extension'];

		if (!is_dir(dirname($newImagePath))) {
			FileHelper::createDirectory(dirname($newImagePath));
		}

		$newWidth = $width;
		$newHeight = $height;
		$newQuality = 70;

		if ($width > $maxWidth) {
			$newWidth = $maxWidth;
			$newHeight = intval($newWidth / $ratio);
		} elseif ($height > $maxHeight) {
			$newHeight = $maxHeight;
			$newWidth = intval($newHeight * $ratio);
		}

		$image = \yii\imagine\Image::getImagine()->open($file->tempName);

		$image->resize(new Box($newWidth, $newHeight));

		$image->save($newImagePath, [
			'quality' => $newQuality,
		]);

		return $newImagePath;
	}

	/**
	 * @param string $url
	 *
	 * @return string
	 *
	 * @throws
	 */
	private function fixThumbnailUrl($url) {
		/** @var Thumbnail $thumbnail */
		$thumbnail = Yii::$app->get('thumbnail');

		$url = str_replace(str_replace("\\", "/", $thumbnail->cachePath), $this->thumbnailsUrl, $url);

		return $url;
	}
}