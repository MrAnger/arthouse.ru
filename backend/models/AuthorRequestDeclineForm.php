<?php

namespace backend\models;

use common\models\AuthorRequest;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class AuthorRequestDeclineForm extends Model {
	/**
	 * @var integer
	 */
	public $requestId;

	/**
	 * @var string
	 */
	public $comment = <<<HTML
Здравствуйте!
Спасибо, что посетили наш сайт и решились написать нам! К сожалению, Ваши работы не подходят к формату сайта. Это ни в коем случае не подразумевает с нашей стороны отрицательной оценки Вашего творчества!
HTML;


	public function rules() {
		return [
			[['requestId'], 'required'],
			[['requestId'], 'integer'],
			[['comment'], 'string'],

			[['requestId'], 'exist', 'skipOnError' => true, 'targetClass' => AuthorRequest::class, 'targetAttribute' => ['requestId' => 'id']],

			[['comment'], 'trim'],
			[['comment'], 'default'],
		];
	}

	public function attributeLabels() {
		return [
			'requestId' => 'Запрос',
			'comment'   => 'Причина отказа',
		];
	}
}
