<?php

use yii\db\Migration;

/**
 * Class m181203_115214_writer_work_content_change_to_long_text
 */
class m181203_115214_writer_work_content_change_to_long_text extends Migration {
	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->alterColumn('{{%writer_work}}', 'content', $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext')->notNull());
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->alterColumn('{{%writer_work}}', 'content', $this->text()->notNull());
	}
}
