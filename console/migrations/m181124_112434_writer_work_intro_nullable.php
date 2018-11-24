<?php

use yii\db\Migration;

/**
 * Class m181124_112434_writer_work_intro_nullable
 */
class m181124_112434_writer_work_intro_nullable extends Migration {
	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->alterColumn('{{%writer_work}}', 'intro', $this->text()->null()->defaultValue(null));
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->alterColumn('{{%writer_work}}', 'intro', $this->text()->notNull());
	}
}
