<?php

use yii\db\Migration;

/**
 * Class m210507_083614_mentor_team_task
 */
class m210507_083614_mentor_create_team_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%mentor_team_task}}', [
            'task_id' => $this->integer()->notNull(),
            'team_id' => $this->integer()->notNull(),
            'point' => $this->integer()->defaultValue(0),
            'created_at' => 'datetime DEFAULT NOW()',
            'updated_at' => 'datetime ON UPDATE NOW()',
        ]);

        $this->addPrimaryKey('mentor_team_task_pk', '{{%mentor_team_task}}', ['task_id', 'team_id']);
        $this->addForeignKey('mentor_team_task_task_id_fk', '{{%mentor_team_task}}', 'task_id', '{{%mentor_task}}', 'id', 'CASCADE');
        $this->addForeignKey('mentor_team_task_team_id_fk', '{{%mentor_team_task}}', 'team_id', '{{%mentor_team}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('mentor_team_task_task_id_fk', '{{%mentor_team_task}}');
        $this->dropForeignKey('mentor_team_task_team_id_fk', '{{%mentor_team_task}}');
        $this->dropTable('{{%mentor_team_task}}');
    }
}
