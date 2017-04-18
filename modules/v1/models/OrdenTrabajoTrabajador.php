<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "orden_trabajo_trabajador".
 *
 * @property string $id
 * @property string $ot_id
 * @property string $tra_id
 *
 * @property OrdenTrabajo $ot
 * @property Trabajador $tra
 */
class OrdenTrabajoTrabajador extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'orden_trabajo_trabajador';
    }

    public function rules()
    {
        return [
            [['ot_id', 'tra_id'], 'required'],
            [['ot_id', 'tra_id'], 'integer'],
            [['ot_id', 'tra_id'], 'unique', 'targetAttribute' => ['ot_id', 'tra_id'], 'message' => 'El trabajador ya existe en esta Orden de trabajo'],
            [['ot_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrdenTrabajo::className(), 'targetAttribute' => ['ot_id' => 'id']],
            [['tra_id'], 'exist', 'skipOnError' => true, 'targetClass' => Trabajador::className(), 'targetAttribute' => ['tra_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ot_id' => 'Orden de trabajo',
            'tra_id' => 'Trabajador',
        ];
    }

    public function extraFields(){
        return ['ot','trabajador'];
    }

    public function getOt()
    {
        return $this->hasOne(OrdenTrabajo::className(), ['id' => 'ot_id']);
    }

    public function getTrabajador()
    {
        return $this->hasOne(Trabajador::className(), ['id' => 'tra_id']);
    }
}
