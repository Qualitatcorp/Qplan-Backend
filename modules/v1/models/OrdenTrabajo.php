<?php

namespace app\modules\v1\models;

use Yii;

class OrdenTrabajo extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'orden_trabajo';
    }

    public function rules()
    {
        return [
            [['emp_id', 'esp_id', 'per_id', 'sol_id', 'inicio', 'termino', 'direccion','personal','tipo'], 'required'],
            [['emp_id', 'esp_id', 'per_id', 'sol_id'], 'integer'],
            [['personal', 'tipo', 'direccion', 'estado'], 'string'],
            ['personal', 'in', 'range' => ['ESTABLE', 'TRANSITORIO']],
            ['tipo', 'in', 'range' => ['CERTIFICACIÓN', 'PRE-CERTIFICACIÓN']],
            // ['estado', 'in', 'range' => ['CERTIFICACIÓN', 'PRE-CERTIFICACIÓN']],
            [['inicio', 'termino'], 'safe'],
            [['sol_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrdenTrabajoSolicitud::className(), 'targetAttribute' => ['sol_id' => 'id']],
            [['emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::className(), 'targetAttribute' => ['emp_id' => 'id']],
            [['esp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Especialidad::className(), 'targetAttribute' => ['esp_id' => 'id']],
            [['sol_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrdenTrabajoSolicitud::className(), 'targetAttribute' => ['sol_id' => 'id']],
            [['per_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perfil::className(), 'targetAttribute' => ['per_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'Orden de Trabajo',
            'emp_id' => 'Empresa Contratista',
            'esp_id' => 'Especialidad',
            'per_id' => 'Perfil de evaluación',
            'sol_id' => 'Solicitud',
            'personal' => 'Tipo de Personal',
            'tipo' => 'Tipo de Certificación',
            'inicio' => 'Fecha de inicio',
            'termino' => 'Fecha de termino',
            'direccion' => 'Dirección de servicio',
            'estado' => 'Estado',
        ];
    }

    public function extraFields()
    {
        return [
        'trabajador',
        'mandante',
        'fichas',
        'solicitud',
        'empresa',
        'especialidad',
        'perfil',
        'countfic',
        'counttra',
        'usuario',
        'modpractica',
        'modetercero',
        'fichanotas',
        'modulos'
        ];
    }

    public function getTrabajador()
    {
        return $this->hasMany(Trabajador::className(), ['id' => 'tra_id'])->viaTable('orden_trabajo_trabajador', ['ot_id' => 'id']);
    }

    public function getMandante()
    {
        return $this->hasOne(Empresa::className(), ['id' => 'emp_id'])->viaTable('orden_trabajo_solicitud', ['id' => 'sol_id']);
    }    
    public function getUsuario()
    {
        return $this->hasOne(User::className(), ['id' => 'usu_id'])->viaTable('orden_trabajo_solicitud', ['id' => 'sol_id']);
    }

    public function getFichas()
    {
        return $this->hasMany(Ficha::className(), ['ot_id' => 'id']);
    }
    public function getCountfic()
    {
        return $this->getFichas()->count();
    }
    public function getCounttra()
    {
        return $this->getTrabajador()->count();
    }
    public function getSolicitud()
    {
        return $this->hasOne(OrdenTrabajoSolicitud::className(), ['id' => 'sol_id']);
    }

    public function getEmpresa()
    {
        return $this->hasOne(Empresa::className(), ['id' => 'emp_id']);
    }

    public function getEspecialidad()
    {
        return $this->hasOne(Especialidad::className(), ['id' => 'esp_id']);
    }

    public function getPerfil()
    {
        return $this->hasOne(Perfil::className(), ['id' => 'per_id']);
    }

    public function getModulos()
    {
        return PerfilModulo::findBySql("SELECT * FROM perfil_modulo WHERE per_id = :id",[':id'=>$this->per_id])->all();
    }

    public function getModpractica()
    {
        return PerfilModulo::findBySql("SELECT * FROM perfil_modulo WHERE per_id = :id AND FIND_IN_SET('PRACTICA', evaluacion)",[':id'=>$this->per_id])->all();
    }

    public function getModtercero()
    {
        return PerfilModulo::findBySql("SELECT * FROM perfil_modulo WHERE per_id = :id AND FIND_IN_SET('TERCERO', evaluacion)",[':id'=>$this->per_id])->all();
    }

    public function getModprimario()
    {
        return PerfilModulo::findBySql("SELECT * FROM perfil_modulo WHERE per_id = :id AND FIND_IN_SET('PRIMARIO', nivel)",[':id'=>$this->per_id])->all();
    }

    public function getFichanotas()
    {
        $list = array();
        $fichas=$this->fichas;
        foreach ($fichas as $model) {
            $list[]=$model->getAttributes(['id','tra_id','proceso','creacion','final','notas']) ;
        }
        return $list;
    }

    public function getFinal()
    {
        if(empty($this->nota)){

        }else{
            return $this->nota;
        }
    }
}
