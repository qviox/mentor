<?php

use yii\db\Migration;

/**
 * Class m210507_083803_mentor_user_team
 */
class m210507_083803_mentor_create_user_team_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%mentor_user_team}}', [
            'user_id' => $this->integer()->notNull(),
            'team_id' => $this->integer()->notNull(),
            'created_at' => 'datetime DEFAULT NOW()',
            'updated_at' => 'datetime ON UPDATE NOW()',
        ]);

        $this->addPrimaryKey('mentor_user_team_pk', '{{%mentor_user_team}}', ['user_id', 'team_id']);
        $this->addForeignKey('mentor_user_team_user_id_fk', '{{%mentor_user_team}}', 'user_id', '{{%user}}', 'id', 'CASCADE');
        $this->addForeignKey('mentor_user_team_team_id_fk', '{{%mentor_user_team}}', 'team_id', '{{%mentor_team}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('mentor_user_team_user_id_fk', '{{%mentor_user_team}}');
        $this->dropForeignKey('mentor_user_team_team_id_fk', '{{%mentor_user_team}}');
        $this->dropTable('{{%mentor_user_team}}');
    }
}
