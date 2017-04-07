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
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trabajador_experiencia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tra_id', 'car_id', 'tipo', 'meses'], 'required'],
            [['tra_id', 'car_id', 'meses'], 'integer'],
            [['tipo', 'funciones'], 'string'],
            [['tra_id'], 'exist', 'skipOnError' => true, 'targetClass' => Trabajador::className(), 'targetAttribute' => ['tra_id' => 'id']],
            [['car_id'], 'exist', 'skipOnError' => true, 'targetClass' => EspecialidadCargo::className(), 'targetAttribute' => ['car_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tra_id' => 'Trabajador',
            'car_id' => 'Cargo',
            'tipo' => 'Tipo',
            'meses' => 'Meses',
            'funciones' => 'Funciones',
        ];
    }

    public function extraFields()
    {
        return ['trabajador','cargo'];
    }
    public function getTrabajador()
    {
        return $this->hasOne(Trabajador::className(), ['id' => 'tra_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCargo()
    {
        return $this->hasOne(EspecialidadCargo::className(), ['id' => 'car_id']);
    }
}
