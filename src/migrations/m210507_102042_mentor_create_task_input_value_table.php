<?php

use yii\db\Migration;

/**
 * Class m210507_102042_mentor_create_task_form_input_value_table
 */
class m210507_102042_mentor_create_task_input_value_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%mentor_task_input_value}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'task_input_id' => $this->integer()->notNull(),
            'val' => $this->text(),
            'created_at' => 'datetime DEFAULT NOW()',
            'updated_at' => 'datetime ON UPDATE NOW()'
        ]);


        $this->addForeignKey(
            'mentor_task_input_value-user_id-fk',
            'mentor_task_input_value',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'mentor_task_input_value-mentor_task_input_id-fk',
            'mentor_task_input_value',
            'task_input_id',
            'mentor_task_input',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%mentor_task_input_value}}');
    }
}
