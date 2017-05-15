<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "clasificacion_categoria".
 *
 * @property integer $id
 * @property string $nombre
 *
 * @property Clasificacion[] $clasificacions
 */
class ClasificacionCategoria extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'clasificacion_categoria';
    }


    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 128],
            [['nombre'], 'unique'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
        ];
    }

    public function getClasificacions()
    {
        return $this->hasMany(Clasificacion::className(), ['cat_id' => 'id']);
    }
}
