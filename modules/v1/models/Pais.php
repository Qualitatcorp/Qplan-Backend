<?php

namespace app\modules\v1\models;

use Yii;


class Pais extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'pais';
    }


    public function rules()
    {
        return [
            [['codigo'], 'required'],
            [['codigo'], 'string', 'max' => 3],
            [['nombre'], 'string', 'max' => 50],
            [['codigo'], 'unique'],
            [['nombre'], 'unique'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codigo' => 'Codigo',
            'nombre' => 'Nombre',
        ];
    }

    public function getEmpresas()
    {
        return $this->hasMany(Empresa::className(), ['pais_id' => 'id']);
    }
}
