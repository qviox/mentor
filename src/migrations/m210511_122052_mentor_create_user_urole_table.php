<?php

use yii\db\Migration;

/**
 * Class m210511_120653_mentor_create_mentor_table
 */
class m210511_122052_mentor_create_user_urole_table extends Migration
{
    /**
     * {@inheritdoc}
     */

    public function safeUp()
    {
        $this->createTable('{{%mentor_user_urole}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'user_role_id' => $this->integer()->notNull(),
        ]);


        $this->addForeignKey(
            'mentor_user_urole-user_id-fk',
            'mentor_user_urole',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'mentor_user_urole-role_id-fk',
            'mentor_user_urole',
            'user_role_id',
            'mentor_urole',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%mentor_user_urole}}');
    }
}
