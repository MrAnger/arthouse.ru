<?php

use yii\db\Migration;

/**
 * Class m181020_081732_profile_add_column_avatar_image_id
 */
class m181020_081732_profile_add_column_avatar_image_id extends Migration {
	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->addColumn('{{%profile}}', 'avatar_image_id', $this->integer(10)->unsigned()->null()->defaultValue(null));

		$this->addForeignKey('FK_avatar_image_id_to_image_table', '{{%profile}}', 'avatar_image_id', '{{%image}}', 'id', 'SET NULL', 'CASCADE');
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->dropForeignKey('FK_avatar_image_id_to_image_table', '{{%profile}}');

		$this->dropColumn('{{%profile}}', 'avatar_image_id');
	}
}
