<?php

use yii\db\Migration;

/**
 * Class m181124_153004_news_add_cover_id
 */
class m181124_153004_news_add_cover_id extends Migration {
	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->addColumn('{{%news}}', 'image_id', $this->integer(10)->unsigned()->null()->defaultValue(null)->after('content'));

		$this->createIndex('FK_news_image', '{{%news}}', ['image_id'], false);
		$this->addForeignKey(
			'fk_news_image_id',
			'{{%news}}', 'image_id',
			'{{%image}}', 'id',
			'SET NULL', 'CASCADE'
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->dropForeignKey('fk_news_image_id', '{{%news}}');
		$this->dropColumn('{{%news}}', 'image_id');
	}
}
