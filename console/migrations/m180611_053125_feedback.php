<?php

use yii\db\Schema;
use yii\db\Migration;

class m180611_053125_feedback extends Migration {

	public function init() {
		$this->db = 'db';
		parent::init();
	}

	public function safeUp() {
		$tableOptions = 'ENGINE=InnoDB';

		$this->createTable('{{%feedback}}', [
			'id'         => $this->primaryKey(10)->unsigned(),
			'status'     => $this->smallInteger(5)->unsigned()->notNull()->defaultValue(0),
			'name'       => $this->string(255)->notNull(),
			'email'      => $this->string(255)->notNull(),
			'phone'      => $this->string(255)->null()->defaultValue(null),
			'text'       => $this->text()->null()->defaultValue(null),
			'created_at' => $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
		], $tableOptions);

	}

	public function safeDown() {
		$this->dropTable('{{%feedback}}');
	}
}
