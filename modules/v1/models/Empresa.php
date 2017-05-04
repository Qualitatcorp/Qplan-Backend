<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "empresa".
 *
 * @property integer $id
 * @property integer $com_id
 * @property string $nombre
 * @property string $rut
 * @property string $razon
 * @property string $giro
 * @property string $fono
 * @property string $mail
 * @property integer $pais_id
 * @property string $creada
 * @property string $habilitada
 *
 * @property Comuna $com
 * @property Pais $pais
 * @property EmpresaClasificacion[] $empresaClasificacions
 * @property EmpresaSucursal[] $empresaSucursals
 * @property EmpresaUser[] $empresaUsers
 * @property User[] $usus
 * @property OrdenTrabajo[] $ordenTrabajos
 * @property TrabajadorExperiencia[] $trabajadorExperiencias
 */
class Empresa extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'empresa';
    }


    public function rules()
    {
        return [
            [['com_id', 'pais_id'], 'integer'],
            [['nombre', 'rut', 'razon'], 'required'],
            [['creada'], 'safe'],
            [['habilitada'], 'string'],
            [['nombre'], 'string', 'max' => 64],
            [['rut'], 'string', 'max' => 12],
            [['razon', 'giro'], 'string', 'max' => 256],
            [['fono', 'mail'], 'string', 'max' => 128],
            [['rut'], 'unique'],
            [['com_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comuna::className(), 'targetAttribute' => ['com_id' => 'com_id']],
            [['pais_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pais::className(), 'targetAttribute' => ['pais_id' => 'id']],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'com_id' => 'Com ID',
            'nombre' => 'Nombre',
            'rut' => 'Rut',
            'razon' => 'Razon',
            'giro' => 'Giro',
            'fono' => 'Fono',
            'mail' => 'Mail',
            'pais_id' => 'Pais ID',
            'creada' => 'Creada',
            'habilitada' => 'Habilitada',
        ];
    }

    public function extraFields(){
        return ['sucursal'];
    }

    public function getCom()
    {
        return $this->hasOne(Comuna::className(), ['com_id' => 'com_id']);
    }

    public function getPais()
    {
        return $this->hasOne(Pais::className(), ['id' => 'pais_id']);
    }

    public function getEmpresaClasificacions()
    {
        return $this->hasMany(EmpresaClasificacion::className(), ['emp_id' => 'id']);
    }

    public function getSucursal()
    {
        return $this->hasMany(EmpresaSucursal::className(), ['emp_id' => 'id']);
    }

    public function getEmpresaUsers()
    {
        return $this->hasMany(EmpresaUser::className(), ['emp_id' => 'id']);
    }

    public function getUsus()
    {
        return $this->hasMany(User::className(), ['id' => 'usu_id'])->viaTable('empresa_user', ['emp_id' => 'id']);
    }

    public function getOrdenTrabajos()
    {
        return $this->hasMany(OrdenTrabajo::className(), ['emp_id' => 'id']);
    }

    public function getTrabajadorExperiencias()
    {
        return $this->hasMany(TrabajadorExperiencia::className(), ['emp_id' => 'id']);
    }
}
