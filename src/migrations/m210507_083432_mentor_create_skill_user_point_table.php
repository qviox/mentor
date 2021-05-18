<?php

use yii\db\Migration;

/**
 * Class m210507_083432_mentor_create_skill_user_point_table
 */
class m210507_083432_mentor_create_skill_user_point_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%mentor_skill_user_point}}', [
            'user_id' => $this->integer(11)->notNull(),
            'skill_id' => $this->integer(11)->notNull(),
            'session_id' => $this->integer(11)->notNull(),
            'point' => $this->smallInteger()->defaultValue(0),
            'created_at' => 'datetime DEFAULT NOW()',
            'updated_at' => 'datetime ON UPDATE NOW()',
        ], $tableOptions);

        $this->addPrimaryKey('mentor_skill_user_point_pk', '{{%mentor_skill_user_point}}', ['user_id', 'skill_id', 'session_id']);
        $this->addForeignKey('mentor_skill_user_point_user_id_fk', '{{%mentor_skill_user_point}}', 'user_id', '{{%user}}', 'id', 'CASCADE');
        $this->addForeignKey('mentor_skill_user_point_skill_id_fk', '{{%mentor_skill_user_point}}', 'skill_id', '{{%mentor_skill}}', 'id', 'CASCADE');
        $this->addForeignKey('mentor_skill_user_point_session_id_fk', '{{%mentor_skill_user_point}}', 'session_id', '{{%mentor_skill_session}}', 'id', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('mentor_skill_user_point_user_id_fk', '{{%mentor_skill_user_point}}');
        $this->dropForeignKey('mentor_skill_user_point_skill_id_fk', '{{%mentor_skill_user_point}}');
        $this->dropForeignKey('mentor_skill_user_point_session_id_fk', '{{%mentor_skill_user_point}}');
        $this->dropTable('{{%mentor_skill_user_point}}');
    }
}
