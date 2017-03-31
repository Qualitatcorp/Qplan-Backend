<?php

namespace app\modules\v1\models;

use Yii;

class Perfil extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'perfil';
    }

    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['descripcion', 'documento'], 'string'],
            [['nombre'], 'string', 'max' => 128],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'documento' => 'Documento',
        ];
    }

    public function extraFields()
    {
        return ['modulos','primario','secundario','practica','teorica','teorica.ficha'];
    }

    public function getClasificacionPerfils()
    {
        return $this->hasMany(ClasificacionPerfil::className(), ['per_id' => 'id']);
    }

    public function getClasificacion()
    {
        return $this->hasMany(Clasificacion::className(), ['id' => 'cla_id'])->viaTable('clasificacion_perfil', ['per_id' => 'id']);
    }

    public function getEmpresaClasificacion()
    {
        return $this->hasMany(EmpresaClasificacion::className(), ['per_id' => 'id']);
    }

    public function getOrdenTrabajos()
    {
        return $this->hasMany(OrdenTrabajo::className(), ['per_id' => 'id']);
    }

    // public function getPerfilEspecialidades()
    // {
    //     return $this->hasMany(PerfilEspecialidad::className(), ['per_id' => 'id']);
    // }

    public function getEspecialidades()
    {
        return $this->hasMany(Especialidad::className(), ['id' => 'esp_id'])->viaTable('perfil_especialidad', ['per_id' => 'id']);
    }

    public function getModulos()
    {
        return $this->hasMany(PerfilModulo::className(), ['per_id' => 'id']);
    }

    public function getPrimario()
    {
        return $this->hasMany(PerfilModulo::className(), ['per_id' => 'id'])->where(['nivel'=>'PRIMARIO']);
    }

    public function getSecundario()
    {
        return $this->hasMany(PerfilModulo::className(), ['per_id' => 'id'])->where(['nivel'=>'SECUNDARIO']);
    }

    public function getPractica()
    {
        return $this->hasMany(PerfilModulo::className(), ['per_id' => 'id'])->where(['like', 'evaluacion', 'PRACTICA']);
    }

    public function getTeorica()
    {
        return $this->hasMany(PerfilModulo::className(), ['per_id' => 'id'])->where(['like', 'evaluacion', 'TEORICA']);
    }    

    public function getTeorica()
    {
        return $this->hasMany(PerfilModulo::className(), ['per_id' => 'id'])->where(['like', 'evaluacion', 'TEORICA']);
    }


}
