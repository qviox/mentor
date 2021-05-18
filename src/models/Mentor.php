<?php

namespace qviox\mentor\models;
use yii\db\ActiveRecord;
class Mentor extends ActiveRecord{
    public static function tableName()
    {
        return '{{%mentor_mentor}}';
    }
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
        ];
    }
}