<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "comuna_provincia".
 *
 * @property integer $pro_id
 * @property string $nombre
 * @property integer $reg_id
 *
 * @property Comuna[] $comunas
 * @property ComunaRegion $reg
 */
class ComunaProvincia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comuna_provincia';
    }

    /**
     * @inheritdoc
     */
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

    /**
     * @inheritdoc
     */
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
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComunas()
    {
        return $this->hasMany(Comuna::className(), ['pro_id' => 'pro_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(ComunaRegion::className(), ['reg_id' => 'reg_id']);
    }
}
