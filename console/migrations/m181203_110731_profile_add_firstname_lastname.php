<?php

use yii\db\Migration;

/**
 * Class m181203_110731_profile_add_firstname_lastname
 */
class m181203_110731_profile_add_firstname_lastname extends Migration {
	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->addColumn('{{%profile}}', 'firstname', $this->string(255)->null()->defaultValue(null)->after('name'));
		$this->addColumn('{{%profile}}', 'lastname', $this->string(255)->null()->defaultValue(null)->after('firstname'));
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->dropColumn('{{%profile}}', 'firstname');
		$this->dropColumn('{{%profile}}', 'lastname');
	}
}
