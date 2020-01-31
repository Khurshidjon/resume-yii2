<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%persons}}`.
 */
class m200130_061451_create_persons_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%persons}}', [
            'id' => $this->primaryKey(),
	        'firstname' => $this->string()->notNull(),
	        'lastname' => $this->string(),
	        'middlename' => $this->string(),
	        'phone' => $this->string(),
	        'email' => $this->string()->unique(),
	        'address' => $this->text(),
	        'avatar' => $this->string(),
	        'hobbies' => $this->text(),
	        'updated_at' => $this->timestamp()->notNull(),
	        'created_at' => $this->timestamp()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%persons}}');
    }
}
