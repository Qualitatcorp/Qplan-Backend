<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "empresa_sucursal".
 *
 * @property string $id
 * @property integer $emp_id
 * @property string $nombre
 * @property string $direccion
 *
 * @property Empresa $emp
 * @property TrabajadorExperiencia[] $trabajadorExperiencias
 */
class EmpresaSucursal extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'empresa_sucursal';
    }


    public function rules()
    {
        return [
            [['emp_id', 'nombre'], 'required'],
            [['emp_id'], 'integer'],
            [['direccion'], 'string'],
            [['nombre'], 'string', 'max' => 128],
            [['emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::className(), 'targetAttribute' => ['emp_id' => 'id']],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'emp_id' => 'Emp ID',
            'nombre' => 'Nombre',
            'direccion' => 'Direccion',
        ];
    }

    public function getEmp()
    {
        return $this->hasOne(Empresa::className(), ['id' => 'emp_id']);
    }

    public function getTrabajadorExperiencias()
    {
        return $this->hasMany(TrabajadorExperiencia::className(), ['suc_id' => 'id']);
    }
}
