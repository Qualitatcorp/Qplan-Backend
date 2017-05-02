<?php

namespace app\modules\v1\models;

use Yii;


class Pais extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pais';
    }

    /**
     * @inheritdoc
     */
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

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codigo' => 'Codigo',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresas()
    {
        return $this->hasMany(Empresa::className(), ['pais_id' => 'id']);
    }
}
