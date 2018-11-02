<?php

use yii\db\Migration;

/**
 * Class m181102_095620_slider_item
 */
class m181102_095620_slider_item extends Migration {
	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->createTable('{{%slider_item}}', [
			'id'          => $this->primaryKey(10)->unsigned()->comment('ID'),
			'slider_id'   => $this->integer(10)->unsigned()->notNull()->comment('Слайдер'),
			'image_id'    => $this->integer(10)->unsigned()->notNull()->comment('Изображение'),
			'name'        => $this->string(255)->notNull()->comment('Название'),
			'description' => $this->text()->null()->defaultValue(null)->comment('Описание'),
			'is_enabled'  => $this->smallInteger(1)->unsigned()->notNull()->defaultValue(1)->comment('Включён'),
			'order'       => $this->smallInteger()->notNull()->defaultValue(1)->comment('Порядок'),
		]);

		$this->addForeignKey('slider_item_image_id_to_image', '{{%slider_item}}', 'image_id', '{{%image}}', 'id', 'CASCADE', 'CASCADE');
		$this->addForeignKey('slider_item_slider_id_to_slider', '{{%slider_item}}', 'slider_id', '{{%slider}}', 'id', 'CASCADE', 'CASCADE');
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->dropForeignKey('slider_item_image_id_to_image', '{{%slider_item}}');
		$this->dropForeignKey('slider_item_slider_id_to_slider', '{{%slider_item}}');

		$this->dropTable('{{%slider_item}}');
	}
}
