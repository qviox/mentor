<?php

use yii\db\Migration;

/**
 * Class m210511_120653_mentor_create_mentor_table
 */
class m210511_120653_mentor_create_urole_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%mentor_urole}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string()->notNull(),
            'label' => $this->string()->notNull(),
        ]);

        $this->insert('mentor_urole', ['type' => 'ROLE_ADMIN', 'label' => 'Админ']);
        $this->insert('mentor_urole', ['type' => 'ROLE_MENTOR', 'label' => 'Ментор']);


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%mentor_urole}}');
    }
}
