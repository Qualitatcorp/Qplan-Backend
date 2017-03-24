<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "orden_trabajo".
 *
 * @property string $id
 * @property integer $emp_id
 * @property integer $esp_id
 * @property string $per_id
 * @property string $sol_id
 * @property string $inicio
 * @property string $termino
 * @property string $direccion
 * @property string $estado
 *
 * @property Ficha[] $fichas
 * @property Trabajador[] $tras
 * @property OrdenTrabajoSolicitud $sol
 * @property Empresa $emp
 * @property Especialidad $esp
 * @property OrdenTrabajoSolicitud $sol0
 * @property OrdenTrabajoTrabajador[] $ordenTrabajoTrabajadors
 * @property Trabajador[] $tras0
 */
class OrdenTrabajo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orden_trabajo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emp_id', 'esp_id', 'per_id', 'sol_id', 'inicio', 'termino', 'direccion'], 'required'],
            [['emp_id', 'esp_id', 'per_id', 'sol_id'], 'integer'],
            [['inicio', 'termino'], 'safe'],
            [['direccion', 'estado'], 'string'],
            [['sol_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrdenTrabajoSolicitud::className(), 'targetAttribute' => ['sol_id' => 'id']],
            [['emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::className(), 'targetAttribute' => ['emp_id' => 'id']],
            [['esp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Especialidad::className(), 'targetAttribute' => ['esp_id' => 'id']],
            [['sol_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrdenTrabajoSolicitud::className(), 'targetAttribute' => ['sol_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'emp_id' => 'Emp ID',
            'esp_id' => 'Esp ID',
            'per_id' => 'Per ID',
            'sol_id' => 'Sol ID',
            'inicio' => 'Inicio',
            'termino' => 'Termino',
            'direccion' => 'Direccion',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFichas()
    {
        return $this->hasMany(Ficha::className(), ['ot_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTras()
    {
        return $this->hasMany(Trabajador::className(), ['id' => 'tra_id'])->viaTable('ficha', ['ot_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSol()
    {
        return $this->hasOne(OrdenTrabajoSolicitud::className(), ['id' => 'sol_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmp()
    {
        return $this->hasOne(Empresa::className(), ['id' => 'emp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEsp()
    {
        return $this->hasOne(Especialidad::className(), ['id' => 'esp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSol0()
    {
        return $this->hasOne(OrdenTrabajoSolicitud::className(), ['id' => 'sol_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdenTrabajoTrabajadors()
    {
        return $this->hasMany(OrdenTrabajoTrabajador::className(), ['ot_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTras0()
    {
        return $this->hasMany(Trabajador::className(), ['id' => 'tra_id'])->viaTable('orden_trabajo_trabajador', ['ot_id' => 'id']);
    }
}
