<?php

use yii\db\Migration;

/**
 * Class m210507_084143_mentor_create_competition_questionnaire_table
 */
class m210507_084143_mentor_create_competition_questionnaire_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%mentor_competition_questionnaire}}', [
            'id' => $this->primaryKey(),
            'user_id'=> $this->integer(),
            'fio' => $this->string(100)->notNull(),
            'email'=> $this->string(),
            'phone'=> $this->string(),
            'gender' =>$this->tinyInteger(),
            'age' =>$this->integer(),
            'region'=>$this->string(100),
            'education'=>$this->string(1000),
            'work'=>$this->string(1000),
            'work_experience' =>$this->string(100),
            'experience' => $this->string(1500),
            'member_voluntary' => $this->string(1500),
            'professional_qualities' => $this->string(1500),
            'leader_social_change' => $this->string(1500),
            'expectations' => $this->string(1500),
            'created_at' => $this->dateTime(),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%mentor_competition_questionnaire}}');
    }
}
