<?php

use yii\db\Schema;
use yii\db\Migration;

class m180611_053630_news extends Migration {

	public function init() {
		$this->db = 'db';
		parent::init();
	}

	public function safeUp() {
		$tableOptions = 'ENGINE=InnoDB';

		$this->createTable('{{%news}}', [
			'id'               => $this->primaryKey(10)->unsigned(),
			'author_id'        => $this->integer(10)->unsigned()->null()->defaultValue(null),
			'name'             => $this->string(250)->notNull(),
			'slug'             => $this->string(255)->notNull(),
			'intro'            => $this->text()->notNull(),
			'content'          => $this->text()->notNull(),
			'created_at'       => $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
			'updated_at'       => $this->timestamp()->notNull()->defaultValue('0000-00-00 00:00:00'),
			'archive_at'       => $this->datetime()->null()->defaultValue(null),
			'archived_at'      => $this->timestamp()->null()->defaultValue(null),
			'meta_title'       => $this->string(255)->null()->defaultValue(null),
			'meta_description' => $this->string(255)->null()->defaultValue(null),
			'meta_keywords'    => $this->string(255)->null()->defaultValue(null),
		], $tableOptions);

		$this->createIndex('author_id_name', '{{%news}}', ['author_id', 'name'], true);
		$this->createIndex('author_id_slug', '{{%news}}', ['author_id', 'slug'], true);
		$this->addForeignKey(
			'fk_news_author_id',
			'{{%news}}', 'author_id',
			'{{%author}}', 'id',
			'CASCADE', 'CASCADE'
		);
	}

	public function safeDown() {
		$this->dropForeignKey('fk_news_author_id', '{{%news}}');
		$this->dropTable('{{%news}}');
	}
}
