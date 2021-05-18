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
class UType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mentor_utype}}';
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

    public static function getTypesId () {
        return self::find()->select('id')->asArray()->all();
    }
    public static function getLabels () {
        return ArrayHelper::map(self::find()->asArray()->all(),'id','label');
    }
}
