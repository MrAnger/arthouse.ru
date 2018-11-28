<?php

use yii\db\Migration;

/**
 * Class m181128_081855_author_work_disable_name_unique
 */
class m181128_081855_author_work_disable_name_unique extends Migration {
	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->dropIndex('author_id_name', '{{%cinema}}');
		$this->dropIndex('author_id_name', '{{%music_work}}');
		$this->dropIndex('author_id_name', '{{%painter_work}}');
		$this->dropIndex('author_id_name', '{{%writer_work}}');
		$this->dropIndex('author_id_name', '{{%photo_work}}');
		$this->dropIndex('author_id_name', '{{%theater}}');
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->createIndex('author_id_name', '{{%cinema}}', ['author_id', 'name'], true);
		$this->createIndex('author_id_name', '{{%music_work}}', ['author_id', 'name'], true);
		$this->createIndex('author_id_name', '{{%painter_work}}', ['author_id', 'name'], true);
		$this->createIndex('author_id_name', '{{%writer_work}}', ['author_id', 'name'], true);
		$this->createIndex('author_id_name', '{{%photo_work}}', ['author_id', 'name'], true);
		$this->createIndex('author_id_name', '{{%theater}}', ['author_id', 'name'], true);
	}
}
