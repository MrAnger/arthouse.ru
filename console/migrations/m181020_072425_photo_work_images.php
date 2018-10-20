<?php

use yii\db\Migration;

/**
 * Class m181020_072425_photo_work_images
 */
class m181020_072425_photo_work_images extends Migration {
	public function init() {
		$this->db = 'db';
		parent::init();
	}

	public function safeUp() {
		$tableOptions = 'ENGINE=InnoDB';

		$this->createTable('{{%photo_work_images}}', [
			'id'         => $this->primaryKey(10)->unsigned(),
			'work_id'    => $this->integer(10)->unsigned()->notNull(),
			'image_id'   => $this->integer(10)->unsigned()->notNull(),
			'sort_order' => $this->integer(10)->unsigned()->notNull()->defaultValue('0'),
		], $tableOptions);

		$this->createIndex('work_id_image_id', '{{%photo_work_images}}', ['work_id', 'image_id'], true);
		$this->createIndex('FK_photo_work_images_image', '{{%photo_work_images}}', ['image_id'], false);
		$this->addForeignKey(
			'fk_photo_work_images_image_id',
			'{{%photo_work_images}}', 'image_id',
			'{{%image}}', 'id',
			'CASCADE', 'CASCADE'
		);
		$this->addForeignKey(
			'fk_photo_work_images_work_id',
			'{{%photo_work_images}}', 'work_id',
			'{{%painter_work}}', 'id',
			'CASCADE', 'CASCADE'
		);
	}

	public function safeDown() {
		$this->dropForeignKey('fk_photo_work_images_image_id', '{{%photo_work_images}}');
		$this->dropForeignKey('fk_photo_work_images_work_id', '{{%photo_work_images}}');
		$this->dropTable('{{%photo_work_images}}');
	}
}
