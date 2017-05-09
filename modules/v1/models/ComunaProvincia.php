<?php

namespace app\modules\v1\models;

use Yii;

class ComunaProvincia extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'comuna_provincia';
    }


    public function rules()
    {
        return [
            [['pro_id'], 'required'],
            [['pro_id', 'reg_id'], 'integer'],
            [['nombre'], 'string', 'max' => 23],
            [
                ['reg_id'], 
                'exist', 
                'skipOnError' => true, 
                'targetClass' => ComunaRegion::className(), 
                'targetAttribute' => [
                    'reg_id' => 'reg_id'
                ]
            ],
        ];
    }


    public function attributeLabels()
    {
        return [
            'pro_id' => 'Pro ID',
            'nombre' => 'Nombre',
            'reg_id' => 'Reg ID',
        ];
    }

    public function fields()
    {
        return ['pro_id', 'nombre'];
    }
    public function extraFields()
    {
        return ['comunas','region'];
    }
    public function getComunas()
    {
        return $this->hasMany(Comuna::className(), ['pro_id' => 'pro_id']);
    }

    public function getRegion()
    {
        return $this->hasOne(ComunaRegion::className(), ['reg_id' => 'reg_id']);
    }
}
