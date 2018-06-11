<?php

use yii\db\Schema;
use yii\db\Migration;

class m180611_053825_writer_work extends Migration {

	public function init() {
		$this->db = 'db';
		parent::init();
	}

	public function safeUp() {
		$tableOptions = 'ENGINE=InnoDB';

		$this->createTable('{{%writer_work}}', [
			'id'               => $this->primaryKey(10)->unsigned(),
			'author_id'        => $this->integer(10)->unsigned()->null()->defaultValue(null),
			'name'             => $this->string(250)->notNull(),
			'slug'             => $this->string(255)->notNull(),
			'intro'            => $this->text()->notNull(),
			'content'          => $this->text()->notNull(),
			'created_at'       => $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
			'updated_at'       => $this->timestamp()->notNull()->defaultValue('0000-00-00 00:00:00'),
			'meta_title'       => $this->string(255)->null()->defaultValue(null),
			'meta_description' => $this->string(255)->null()->defaultValue(null),
			'meta_keywords'    => $this->string(255)->null()->defaultValue(null),
		], $tableOptions);

		$this->createIndex('author_id_name', '{{%writer_work}}', ['author_id', 'name'], true);
		$this->createIndex('author_id_slug', '{{%writer_work}}', ['author_id', 'slug'], true);
		$this->addForeignKey(
			'fk_writer_work_author_id',
			'{{%writer_work}}', 'author_id',
			'{{%author}}', 'id',
			'CASCADE', 'CASCADE'
		);
	}

	public function safeDown() {
		$this->dropForeignKey('fk_writer_work_author_id', '{{%writer_work}}');
		$this->dropTable('{{%writer_work}}');
	}
}
