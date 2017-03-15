<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "comuna_region".
 *
 * @property integer $reg_id
 * @property string $nombre
 * @property string $ISO_3166_2_CL
 *
 * @property ComunaProvincia[] $comunaProvincias
 */
class ComunaRegion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comuna_region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reg_id'], 'required'],
            [['reg_id'], 'integer'],
            [['nombre'], 'string', 'max' => 50],
            [['ISO_3166_2_CL'], 'string', 'max' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'reg_id' => 'Reg ID',
            'nombre' => 'Nombre',
            'ISO_3166_2_CL' => 'Iso 3166 2  Cl',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComunaProvincias()
    {
        return $this->hasMany(ComunaProvincia::className(), ['reg_id' => 'reg_id']);
    }
}
