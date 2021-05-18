<?php

use yii\db\Migration;

/**
 * Class m210507_083603_mentor_create_team_table
 */
class m210507_083603_mentor_create_team_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%mentor_team}}', [
            'id' => $this->primaryKey(),
            'mentor_id'=> $this->integer()->null(),
            'name' => $this->string(),
            'description' => $this->text(),
            'total_points'=> $this->integer()->defaultValue(0),
            'created_at' => 'datetime DEFAULT NOW()',
            'updated_at' => 'datetime ON UPDATE NOW()',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%mentor_team}}');
    }
}
