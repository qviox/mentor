<?php

namespace qviox\mentor\models\rbac;

use Yii;
use yii\helpers\ArrayHelper;
use qviox\mentor\models\rbac\UserURole;
/**
 * This is the model class for table "user_types".
 *
 * @property int $id
 * @property string $type
 * @property string $label
 */
class URole extends \yii\db\ActiveRecord
{
    const ROLE_ADMIN=1;
    const ROLE_MENTOR=2;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mentor_urole}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'label'], 'required'],
            [['type', 'label'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'label' => 'Label',
        ];
    }

    public static function getRolesId () {
        return self::find()->select('id')->asArray()->all();
    }
    public static function getLabels () {
        return ArrayHelper::map(self::find()->asArray()->all(),'id','label');
    }
    public static function checkUserAccess($area){


        switch ($area){
            case "RBAC":
                if ((!\Yii::$app->user->isGuest) && (!in_array(Yii::$app->user->identity->email,Yii::$app->getModule('mentor')->adminEmails)))
                    return false;
                  return true;
            case "ADMIN":
                if ((!\Yii::$app->user->isGuest) && !((in_array(Yii::$app->user->identity->email,Yii::$app->getModule('mentor')->adminEmails)) || (UserURole::findOne(['user_id'=>Yii::$app->user->id,'user_role_id'=>1]))))
                    return false;
                return true;
            case "MENTOR":
                if ((!\Yii::$app->user->isGuest) && !(UserURole::findOne(['user_id'=>Yii::$app->user->id,'user_role_id'=>2]) || (in_array(Yii::$app->user->identity->email,Yii::$app->getModule('mentor')->adminEmails))))
                    return false;
                return true;

            default:
                return false;

        }
    }
}
