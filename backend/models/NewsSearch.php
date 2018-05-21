<?php

namespace backend\models;

use common\models\News;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class NewsSearch extends News {
	/**
	 * @inheritdoc
	 */
	public function scenarios() {
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return array_merge(parent::rules(), []);
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [];
	}

	/**
	 * @param array $params
	 * @param array $overriddenParams
	 *
	 * @return ActiveDataProvider
	 */
	public function search($params, $overriddenParams = []) {
		$this->load($params);

		$this->setAttributes($overriddenParams, false);

		$query = News::find()
			->where([
				'author_id' => $this->author_id,
			]);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		$query->andFilterWhere([
			'AND',
			['like', 'name', $this->name],
			['like', 'slug', $this->slug],
		]);

		return $dataProvider;
	}

	public function formName() {
		return '';
	}
}
