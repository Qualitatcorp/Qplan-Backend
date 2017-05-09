<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "trabajador_experiencia".
 *
 * @property string $id
 * @property string $tra_id
 * @property integer $car_id
 * @property string $tipo
 * @property integer $meses
 * @property string $funciones
 *
 * @property Trabajador $tra
 * @property EspecialidadCargo $car
 */
class TrabajadorExperiencia extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'trabajador_experiencia';
    }


    public function rules()
    {
        return [
            [['tra_id', 'rubro', 'tipo', 'meses'], 'required'],
            [['tra_id', 'meses'], 'integer'],
            [['tipo', 'rubro', 'funciones'], 'string'],
            [['tra_id'], 'exist', 'skipOnError' => true, 'targetClass' => Trabajador::className(), 'targetAttribute' => ['tra_id' => 'id']]
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tra_id' => 'Trabajador',
            'rubro' => 'Rubro',
            'tipo' => 'Tipo',
            'meses' => 'Meses',
            'funciones' => 'Funciones',
        ];
    }

    public function extraFields()
    {
        return ['trabajador'];
    }
    public function getTrabajador()
    {
        return $this->hasOne(Trabajador::className(), ['id' => 'tra_id']);
    }
}
