<?php

namespace backend\models;

use common\models\Author;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class AuthorSearch extends Author {
	/**
	 * @var string
	 */
	public $email;

	/**
	 * @var string
	 */
	public $name;

	/**
	 * @var string
	 */
	public $workType;

	/**
	 * @inheritdoc
	 */
	public function scenarios() {
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}

	public function rules() {
		return array_merge(parent::rules(), [
			[['email', 'name', 'workType'], 'trim'],
			[['email', 'name', 'workType'], 'default'],
		]);
	}

	/**
	 * @param array $params
	 * @param array $overriddenParams
	 *
	 * @return ActiveDataProvider
	 */
	public function search($params, $overriddenParams = []) {
		$query = Author::find()
			->joinWith('user ut')
			->joinWith('user.profile upt');

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		$this->load($params);

		$this->setAttributes($overriddenParams, false);

		$query->andFilterWhere([
			'AND',
			['like', 'ut.email', $this->email],
			['like', 'upt.name', $this->name],
			['=', $this->workType, ((!empty($this->workType)) ? 1 : null)],
		]);

		return $dataProvider;
	}

	public static function getWorkTypeList() {
		return [
			'is_painter'         => 'Художник',
			'is_cinematographer' => 'Киношник',
			'is_writer'          => 'Писатель',
			'is_musician'        => 'Музыкант',
		];
	}

	public function attributeLabels() {
		return array_merge(parent::attributeLabels(), [
			'email'    => 'Email',
			'name'     => 'Имя',
			'workType' => 'Тип',
		]);
	}

	public function formName() {
		return '';
	}
}
