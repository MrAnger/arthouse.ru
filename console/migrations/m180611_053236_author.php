<?php

use yii\db\Schema;
use yii\db\Migration;

class m180611_053236_author extends Migration {

	public function init() {
		$this->db = 'db';
		parent::init();
	}

	public function safeUp() {
		$tableOptions = 'ENGINE=InnoDB';

		$this->createTable('{{%author}}', [
			'id'                 => $this->primaryKey(10)->unsigned(),
			'user_id'            => $this->integer(11)->notNull(),
			'is_painter'         => $this->smallInteger(1)->unsigned()->notNull()->defaultValue(0),
			'is_cinematographer' => $this->smallInteger(1)->unsigned()->notNull()->defaultValue(0),
			'is_writer'          => $this->smallInteger(1)->unsigned()->notNull()->defaultValue(0),
			'is_musician'        => $this->smallInteger(1)->unsigned()->notNull()->defaultValue(0),
		], $tableOptions);

		$this->createIndex('user_id', '{{%author}}', ['user_id'], true);
		$this->addForeignKey(
			'fk_author_user_id',
			'{{%author}}', 'user_id',
			'{{%user}}', 'id',
			'CASCADE', 'CASCADE'
		);
	}

	public function safeDown() {
		$this->dropForeignKey('fk_author_user_id', '{{%author}}');
		$this->dropTable('{{%author}}');
	}
}
