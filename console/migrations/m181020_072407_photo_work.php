<?php

use yii\db\Migration;

/**
 * Class m181020_072407_photo_work
 */
class m181020_072407_photo_work extends Migration {
	public function init() {
		$this->db = 'db';
		parent::init();
	}

	public function safeUp() {
		$tableOptions = 'ENGINE=InnoDB';

		$this->createTable('{{%photo_work}}', [
			'id'               => $this->primaryKey(10)->unsigned(),
			'author_id'        => $this->integer(10)->unsigned()->notNull(),
			'name'             => $this->string(250)->notNull(),
			'slug'             => $this->string(255)->notNull(),
			'image_url'        => $this->string(1500)->null()->defaultValue(null),
			'image_id'         => $this->integer(10)->unsigned()->null()->defaultValue(null),
			'description'      => $this->text()->null()->defaultValue(null),
			'created_at'       => $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
			'updated_at'       => $this->timestamp()->notNull()->defaultValue('0000-00-00 00:00:00'),
			'meta_title'       => $this->string(255)->null()->defaultValue(null),
			'meta_description' => $this->string(255)->null()->defaultValue(null),
			'meta_keywords'    => $this->string(255)->null()->defaultValue(null),
		], $tableOptions);

		$this->createIndex('author_id_name', '{{%photo_work}}', ['author_id', 'name'], true);
		$this->createIndex('author_id_slug', '{{%photo_work}}', ['author_id', 'slug'], true);
		$this->createIndex('FK_music_work_image', '{{%photo_work}}', ['image_id'], false);
		$this->addForeignKey(
			'fk_photo_work_author_id',
			'{{%photo_work}}', 'author_id',
			'{{%author}}', 'id',
			'CASCADE', 'CASCADE'
		);
		$this->addForeignKey(
			'fk_photo_work_image_id',
			'{{%photo_work}}', 'image_id',
			'{{%image}}', 'id',
			'SET NULL', 'CASCADE'
		);
	}

	public function safeDown() {
		$this->dropForeignKey('fk_photo_work_author_id', '{{%photo_work}}');
		$this->dropForeignKey('fk_photo_work_image_id', '{{%photo_work}}');
		$this->dropTable('{{%photo_work}}');
	}
}
