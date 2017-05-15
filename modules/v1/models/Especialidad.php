<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "especialidad".
 *
 * @property integer $id
 * @property integer $car_id
 * @property string $nombre
 *
 * @property EspecialidadCargo $car
 * @property OrdenTrabajo[] $ordenTrabajos
 * @property PerfilEspecialidad[] $perfilEspecialidads
 * @property Perfil[] $pers
 * @property TrabajadorExperiencia[] $trabajadorExperiencias
 */
class Especialidad extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'especialidad';
    }


    public function rules()
    {
        return [
            [['car_id', 'nombre'], 'required'],
            [['car_id'], 'integer'],
            [['nombre'], 'string', 'max' => 128],
            [['car_id'], 'exist', 'skipOnError' => true, 'targetClass' => EspecialidadCargo::className(), 'targetAttribute' => ['car_id' => 'id']],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'car_id' => 'Car ID',
            'nombre' => 'Nombre',
        ];
    }

    public function getCar()
    {
        return $this->hasOne(EspecialidadCargo::className(), ['id' => 'car_id']);
    }

    public function getOrdenTrabajos()
    {
        return $this->hasMany(OrdenTrabajo::className(), ['esp_id' => 'id']);
    }

    public function getPerfilEspecialidads()
    {
        return $this->hasMany(PerfilEspecialidad::className(), ['esp_id' => 'id']);
    }

    public function getPers()
    {
        return $this->hasMany(Perfil::className(), ['id' => 'per_id'])->viaTable('perfil_especialidad', ['esp_id' => 'id']);
    }

    public function getTrabajadorExperiencias()
    {
        return $this->hasMany(TrabajadorExperiencia::className(), ['esp_id' => 'id']);
    }
}
