<?php

use yii\db\Migration;

/**
 * Class m181103_053707_author_add_column_is_theater
 */
class m181103_053707_author_add_column_is_theater extends Migration {
	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->addColumn('{{%author}}', 'is_theater', $this->smallInteger(1)->unsigned()->notNull()->defaultValue(0));
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->dropColumn('{{%author}}', 'is_theater');
	}
}
