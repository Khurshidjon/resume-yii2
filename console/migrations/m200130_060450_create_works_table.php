<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%works}}`.
 */
class m200130_060450_create_works_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%works}}', [
	        'id' => $this->primaryKey(),
	        'title' => $this->string(),
	        'from_date' => $this->string(),
	        'to_date' => $this->string()->comment("Agar kiritilmagan bo'lsa demak hali ishlayapti shu yerda"),
	        'description' => $this->text(),
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
        $this->dropTable('{{%works}}');
    }
}
