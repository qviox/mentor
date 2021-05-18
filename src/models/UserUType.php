<?php

namespace qviox\mentor\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "user_types".
 *
 * @property int $id
 * @property string $type
 * @property string $label
 */
class UserUType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mentor_user_utype}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'user_type_id'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */



}
