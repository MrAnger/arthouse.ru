<?php

use yii\db\Migration;

/**
 * Class m181103_054249_theater_work
 */
class m181103_054249_theater_work extends Migration {
	public function init() {
		$this->db = 'db';
		parent::init();
	}

	public function safeUp() {
		$tableOptions = 'ENGINE=InnoDB';

		$this->createTable('{{%theater}}', [
			'id'               => $this->primaryKey(10)->unsigned(),
			'author_id'        => $this->integer(10)->unsigned()->notNull(),
			'name'             => $this->string(250)->notNull(),
			'slug'             => $this->string(255)->notNull(),
			'video_url'        => $this->string(1500)->notNull(),
			'video_code'       => $this->string(2000)->null()->defaultValue(null),
			'image_url'        => $this->string(1500)->null()->defaultValue(null),
			'image_id'         => $this->integer(10)->unsigned()->null()->defaultValue(null),
			'description'      => $this->text()->null()->defaultValue(null),
			'created_at'       => $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
			'updated_at'       => $this->timestamp()->notNull()->defaultValue('0000-00-00 00:00:00'),
			'meta_title'       => $this->string(255)->null()->defaultValue(null),
			'meta_description' => $this->string(255)->null()->defaultValue(null),
			'meta_keywords'    => $this->string(255)->null()->defaultValue(null),
		], $tableOptions);

		$this->createIndex('author_id_name', '{{%theater}}', ['author_id', 'name'], true);
		$this->createIndex('author_id_slug', '{{%theater}}', ['author_id', 'slug'], true);
		$this->createIndex('FK_theater_image', '{{%theater}}', ['image_id'], false);
		$this->addForeignKey(
			'fk_theater_author_id',
			'{{%theater}}', 'author_id',
			'{{%author}}', 'id',
			'CASCADE', 'CASCADE'
		);
		$this->addForeignKey(
			'fk_theater_image_id',
			'{{%theater}}', 'image_id',
			'{{%image}}', 'id',
			'SET NULL', 'CASCADE'
		);
	}

	public function safeDown() {
		$this->dropForeignKey('fk_theater_author_id', '{{%theater}}');
		$this->dropForeignKey('fk_theater_image_id', '{{%theater}}');
		$this->dropTable('{{%theater}}');
	}
}
