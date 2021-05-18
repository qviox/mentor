<?php

use yii\db\Migration;

/**
 * Class m210507_083542_mentor_create_task_table
 */
class m210507_083542_mentor_create_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%mentor_task}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'type' => $this->string(10)->notNull(),
            'description' => $this->text(),
            'created_at' => 'datetime DEFAULT NOW()',
            'updated_at' => 'datetime ON UPDATE NOW()',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%mentor_task}}');
    }
}
