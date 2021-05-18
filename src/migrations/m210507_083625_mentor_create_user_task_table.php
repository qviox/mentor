<?php

use yii\db\Migration;

/**
 * Class m210507_083625_mentor_user_task
 */
class m210507_083625_mentor_create_user_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%mentor_user_task}}', [
            'user_id' => $this->integer()->notNull(),
            'task_id' => $this->integer()->notNull(),
            'point' => $this->integer()->defaultValue(0),
            'created_at' => 'datetime DEFAULT NOW()',
            'updated_at' => 'datetime ON UPDATE NOW()',
        ]);

        $this->addPrimaryKey('mentor_user_task_pk', '{{%mentor_user_task}}', ['user_id', 'task_id']);
        $this->addForeignKey('mentor_user_task_user_id_fk', '{{%mentor_user_task}}', 'user_id', '{{%user}}', 'id', 'CASCADE');
        $this->addForeignKey('mentor_user_task_task_id_fk', '{{%mentor_user_task}}', 'task_id', '{{%mentor_task}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('mentor_user_task_user_id_fk', '{{%mentor_user_task}}');
        $this->dropForeignKey('mentor_user_task_task_id_fk', '{{%mentor_user_task}}');
        $this->dropTable('{{%mentor_user_task}}');
    }
}
