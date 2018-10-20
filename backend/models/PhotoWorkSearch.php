<?php

namespace backend\models;

use common\models\PhotoWork;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

class PhotoWorkSearch extends PhotoWork {
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

		$queryWhere = [];

		if ($this->author_id === null) {
			$queryWhere[] = 'AND';
			$queryWhere[] = new Expression('author_id IS NULL');
		} else {
			$queryWhere['author_id'] = $this->author_id;
		}

		$query = PhotoWork::find()
			->where($queryWhere);

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
