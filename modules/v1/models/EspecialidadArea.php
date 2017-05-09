<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "especialidad_area".
 *
 * @property integer $id
 * @property string $nombre
 *
 * @property EspecialidadCargo[] $especialidadCargos
 */
class EspecialidadArea extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'especialidad_area';
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

    public function getEspecialidadCargos()
    {
        return $this->hasMany(EspecialidadCargo::className(), ['are_id' => 'id']);
    }
}
