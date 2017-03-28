<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "trabajador_experiencia".
 *
 * @property string $id
 * @property string $tra_id
 * @property integer $esp_id
 * @property integer $emp_id
 * @property string $suc_id
 * @property string $inicio
 * @property string $termino
 * @property string $cargo
 * @property string $funciones
 *
 * @property Trabajador $tra
 * @property Especialidad $esp
 * @property Empresa $emp
 * @property EmpresaSucursal $suc
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
            [['tra_id', 'inicio', 'termino', 'cargo'], 'required'],
            [['tra_id', 'esp_id', 'emp_id', 'suc_id'], 'integer'],
            [['inicio', 'termino'], 'safe'],
            [['funciones'], 'string'],
            [['cargo'], 'string', 'max' => 128],
            [['tra_id'], 'exist', 'skipOnError' => true, 'targetClass' => Trabajador::className(), 'targetAttribute' => ['tra_id' => 'id']],
            [['esp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Especialidad::className(), 'targetAttribute' => ['esp_id' => 'id']],
            [['emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::className(), 'targetAttribute' => ['emp_id' => 'id']],
            [['suc_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmpresaSucursal::className(), 'targetAttribute' => ['suc_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tra_id' => 'Tra ID',
            'esp_id' => 'Esp ID',
            'emp_id' => 'Emp ID',
            'suc_id' => 'Suc ID',
            'inicio' => 'Inicio',
            'termino' => 'Termino',
            'cargo' => 'Cargo',
            'funciones' => 'Funciones',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTra()
    {
        return $this->hasOne(Trabajador::className(), ['id' => 'tra_id']);
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
    public function getEmp()
    {
        return $this->hasOne(Empresa::className(), ['id' => 'emp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSuc()
    {
        return $this->hasOne(EmpresaSucursal::className(), ['id' => 'suc_id']);
    }
}