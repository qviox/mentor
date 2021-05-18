<?php

use yii\db\Migration;


class m210507_134751_mentor_create_utype_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%mentor_utype}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string()->notNull(),
            'label' => $this->string()->notNull(),
        ]);

        $this->insert('mentor_utype', ['type' => 'TYPE_TEACHER', 'label' => 'Преподаватель']);
        $this->insert('mentor_utype', ['type' => 'TYPE_EXPERT', 'label' => 'Эксперт']);
        $this->insert('mentor_utype', ['type' => 'TYPE_VIEWER', 'label' => 'Преподаватель-зритель']);
        $this->insert('mentor_utype', ['type' => 'TYPE_PARTICIPANT', 'label' => 'Участник']);


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%mentor_utype}}');
    }
}
