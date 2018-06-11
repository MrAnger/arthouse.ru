<?php

use yii\db\Schema;
use yii\db\Migration;

class m180611_053800_painter_work_images extends Migration {

	public function init() {
		$this->db = 'db';
		parent::init();
	}

	public function safeUp() {
		$tableOptions = 'ENGINE=InnoDB';

		$this->createTable('{{%painter_work_images}}', [
			'id'         => $this->primaryKey(10)->unsigned(),
			'work_id'    => $this->integer(10)->unsigned()->notNull(),
			'image_id'   => $this->integer(10)->unsigned()->notNull(),
			'sort_order' => $this->integer(10)->unsigned()->notNull()->defaultValue('0'),
		], $tableOptions);

		$this->createIndex('work_id_image_id', '{{%painter_work_images}}', ['work_id', 'image_id'], true);
		$this->createIndex('FK_painter_work_images_image', '{{%painter_work_images}}', ['image_id'], false);
		$this->addForeignKey(
			'fk_painter_work_images_image_id',
			'{{%painter_work_images}}', 'image_id',
			'{{%image}}', 'id',
			'CASCADE', 'CASCADE'
		);
		$this->addForeignKey(
			'fk_painter_work_images_work_id',
			'{{%painter_work_images}}', 'work_id',
			'{{%painter_work}}', 'id',
			'CASCADE', 'CASCADE'
		);
	}

	public function safeDown() {
		$this->dropForeignKey('fk_painter_work_images_image_id', '{{%painter_work_images}}');
		$this->dropForeignKey('fk_painter_work_images_work_id', '{{%painter_work_images}}');
		$this->dropTable('{{%painter_work_images}}');
	}
}
