<?php

use yii\db\Migration;

/**
 * Class m181121_120355_block_code_allow_null
 */
class m181121_120355_block_content_allow_null extends Migration {
	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->alterColumn('{{%block}}', 'content', $this->text()->null()->defaultValue(null));
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->alterColumn('{{%block}}', 'content', $this->text()->notNull());
	}
}
