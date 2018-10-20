<?php

use yii\db\Migration;

/**
 * Class m181020_071311_author_add_column_is_photo
 */
class m181020_071311_author_add_column_is_photo extends Migration {
	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->addColumn('{{%author}}', 'is_photo', $this->smallInteger(1)->unsigned()->notNull()->defaultValue(0));
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->dropColumn('{{%author}}', 'is_photo');
	}
}
