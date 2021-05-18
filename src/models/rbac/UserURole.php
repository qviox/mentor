<?php

namespace qviox\mentor\models\rbac;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "user_types".
 *
 * @property int $id
 * @property string $type
 * @property string $label
 */
class UserURole extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mentor_user_urole}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'user_role_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */



}
