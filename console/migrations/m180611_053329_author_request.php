<?php

use yii\db\Schema;
use yii\db\Migration;

class m180611_053329_author_request extends Migration {

	public function init() {
		$this->db = 'db';
		parent::init();
	}

	public function safeUp() {
		$tableOptions = 'ENGINE=InnoDB';

		$this->createTable('{{%author_request}}', [
			'id'         => $this->primaryKey(10)->unsigned(),
			'status'     => $this->smallInteger(1)->unsigned()->notNull()->defaultValue(0),
			'name'       => $this->string(255)->notNull(),
			'email'      => $this->string(255)->notNull(),
			'about'      => $this->text()->notNull(),
			'created_at' => $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
			'updated_at' => $this->timestamp()->notNull()->defaultValue('0000-00-00 00:00:00'),
		], $tableOptions);

	}

	public function safeDown() {
		$this->dropTable('{{%author_request}}');
	}
}
