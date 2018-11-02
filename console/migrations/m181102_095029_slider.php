<?php

use yii\db\Migration;

/**
 * Class m181102_095029_slider
 */
class m181102_095029_slider extends Migration {
	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->createTable('{{%slider}}', [
			'id'         => $this->primaryKey(10)->unsigned()->comment('ID'),
			'name'       => $this->string(250)->notNull()->comment('Название'),
			'code'       => $this->string(255)->notNull()->comment('Код'),
			'is_enabled' => $this->smallInteger(1)->unsigned()->notNull()->defaultValue(1)->comment('Включён'),
		]);

		$this->createIndex('slider_code_unique', '{{%slider}}', ['code'], true);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->dropTable('{{%slider}}');
	}
}
