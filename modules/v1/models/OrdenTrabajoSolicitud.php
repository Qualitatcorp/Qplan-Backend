<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "orden_trabajo_solicitud".
 *
 * @property string $id
 * @property integer $emp_id
 * @property string $usu_id
 * @property string $creacion
 * @property string $inicio
 * @property string $termino
 *
 * @property OrdenTrabajo[] $ordenTrabajos
 * @property OrdenTrabajo[] $ordenTrabajos0
 * @property Empresa $emp
 * @property User $usu
 */
class OrdenTrabajoSolicitud extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'orden_trabajo_solicitud';
    }


    public function rules()
    {
        return [
            [['emp_id', 'usu_id', 'creacion', 'inicio', 'termino'], 'required'],
            [['emp_id', 'usu_id'], 'integer'],
            [['creacion', 'inicio', 'termino'], 'safe'],
            [['emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::className(), 'targetAttribute' => ['emp_id' => 'id']],
            [['usu_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['usu_id' => 'id']],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'emp_id' => 'Emp ID',
            'usu_id' => 'Usu ID',
            'creacion' => 'Creacion',
            'inicio' => 'Inicio',
            'termino' => 'Termino',
        ];
    }

    public function getOrdenTrabajos()
    {
        return $this->hasMany(OrdenTrabajo::className(), ['sol_id' => 'id']);
    }

    public function getOrdenTrabajos0()
    {
        return $this->hasMany(OrdenTrabajo::className(), ['sol_id' => 'id']);
    }

    public function getEmp()
    {
        return $this->hasOne(Empresa::className(), ['id' => 'emp_id']);
    }

    public function getUsu()
    {
        return $this->hasOne(User::className(), ['id' => 'usu_id']);
    }
}
