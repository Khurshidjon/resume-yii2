<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%certificats}}`.
 */
class m200130_061320_create_certificats_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%certificats}}', [
	        'id' => $this->primaryKey(),
	        'title' => $this->string(),
	        'filename' => $this->string(),
	        'person_id' => $this->string(),
	        'updated_at' => $this->timestamp()->notNull(),
	        'created_at' => $this->timestamp()->notNull(),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%certificats}}');
    }
}
