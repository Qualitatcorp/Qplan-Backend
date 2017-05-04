<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "especialidad_cargo".
 *
 * @property integer $id
 * @property integer $are_id
 * @property string $nombre
 *
 * @property Especialidad[] $especialidads
 * @property EspecialidadArea $are
 */
class EspecialidadCargo extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'especialidad_cargo';
    }


    public function rules()
    {
        return [
            [['are_id', 'nombre'], 'required'],
            [['are_id'], 'integer'],
            [['nombre'], 'string', 'max' => 128],
            [['are_id'], 'exist', 'skipOnError' => true, 'targetClass' => EspecialidadArea::className(), 'targetAttribute' => ['are_id' => 'id']],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'are_id' => 'Are ID',
            'nombre' => 'Nombre',
        ];
    }

    public function getEspecialidads()
    {
        return $this->hasMany(Especialidad::className(), ['car_id' => 'id']);
    }

    public function getAre()
    {
        return $this->hasOne(EspecialidadArea::className(), ['id' => 'are_id']);
    }
}
