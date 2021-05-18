<?php

use yii\db\Migration;

class m210507_134752_mentor_create_user_utype_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%mentor_user_utype}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'user_type_id'=>$this->integer()->notNull(),
        ]);


        $this->addForeignKey(
            'mentor_user_utype-user_id-fk',
            'mentor_user_utype',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'mentor_user_utype-utype_id-fk',
            'mentor_user_utype',
            'user_type_id',
            'mentor_utype',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%mentor_user_utype}}');
    }
}
