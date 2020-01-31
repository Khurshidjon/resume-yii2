<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%educations}}`.
 */
class m200130_060445_create_educations_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%educations}}', [
            'id' => $this->primaryKey(),
	        'title' => $this->string(),
	        'from_date' => $this->string(),
	        'to_date' => $this->string()->comment("Agar kiritilmagan bo'lsa demak hali o'qiyapti shu yerda"),
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
        $this->dropTable('{{%educations}}');
    }
}
