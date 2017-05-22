<?php

namespace app\modules\v1\models;

use Yii;

class Trabajador extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'trabajador';
    }

    public function rules()
    {
        return [
            [['com_id', 'pais_id', 'antiguedad', 'hijos'], 'integer'],
            [['rut'], 'required'],
            [['nacimiento', 'creacion', 'modificacion'], 'safe'],
            [['civil', 'licencia', 'talla', 'direccion', 'afp', 'prevision', 'nivel','sexo'], 'string'],
            [['rut'], 'string', 'max' => 12],
            [['nombre', 'paterno', 'materno'], 'string', 'max' => 64],
            [['fono'], 'string', 'max' => 36],
            [['mail', 'gerencia'], 'string', 'max' => 128],
            [['contacto'], 'string', 'max' => 256],
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
            'pais_id' => 'Pais ID',
            'rut' => 'Rut',
            'nombre' => 'Nombre',
            'paterno' => 'Paterno',
            'materno' => 'Materno',
            'nacimiento' => 'Nacimiento',
            'fono' => 'Fono',
            'mail' => 'Mail',
            'gerencia' => 'Gerencia',
            'antiguedad' => 'Antiguedad',
            'civil' => 'Civil',
            'hijos' => 'Hijos',
            'licencia' => 'Licencia',
            'talla' => 'Talla',
            'direccion' => 'Direccion',
            'contacto' => 'Contacto',
            'afp' => 'Afp',
            'prevision' => 'Prevision',
            'nivel' => 'Nivel',
            'creacion' => 'Creacion',
            'modificacion' => 'Modificacion',
            'sexo' => 'Sexo'
        ];
    }

    public function fields(){
        return [
            'id',
            'rut',
            'pais',
            'comuna',
            'nombre',
            'paterno',
            'materno',
            'nacimiento',
            'fono',
            'mail',
            'gerencia',
            'antiguedad',
            'civil',
            'hijos',
            'licencia',
            'talla',
            'direccion',
            'contacto',
            'afp',
            'prevision',
            'nivel',
            'creacion',
            'modificacion',
            'sexo',
            'meses'
        ];
    }

    public function extraFields(){
        return ['ot','ots','comuna','pais','experiencias','ponderacion'];
    }

    public function getFichas()
    {
        return $this->hasMany(Ficha::className(), ['tra_id' => 'id']);
    }

    public function getOt()
    {
        return OrdenTrabajo::findBySql("SELECT * FROM orden_trabajo WHERE orden_trabajo.id IN (SELECT orden_trabajo_trabajador.ot_id AS id FROM orden_trabajo_trabajador WHERE orden_trabajo_trabajador.tra_id = :id) AND orden_trabajo.estado <> 'CERRADO' AND orden_trabajo.id NOT IN (SELECT ficha.ot_id AS id FROM ficha WHERE ficha.proceso LIKE '%FINALIZADO TEORICO%' AND ficha.tra_id = :id)",[':id'=>$this->id]);
    }

    public function getOts()
    {
        return $this->hasMany(OrdenTrabajo::className(), ['id' => 'ot_id'])->viaTable('orden_trabajo_trabajador', ['tra_id' => 'id']);
    }

    public function getComuna()
    {
        return $this->hasOne(Comuna::className(), ['com_id' => 'com_id']);
    }

    public function getPais()
    {
        return $this->hasOne(Pais::className(), ['id' => 'pais_id']);
    }

    public function getExperiencias()
    {
        return $this->hasMany(TrabajadorExperiencia::className(), ['tra_id' => 'id']);
    }

    public function getNotaBase()
    {
        switch ($this->nivel) {
                case 'Basica completa':
                    return 0.166666667;
                break;
                case 'Media incompleta':
                    return 0.25;
                break;
                case 'Media completa':
                    return 0.333333333;
                break;
                case 'Tecnica':
                case 'Técnico en nivel superior incompleta':
                    return 0.416666667;
                break;
                case 'Técnico en nivel superior':
                    return 0.5;
                break;
                case 'Profesional incompleta':
                    return 0.583333333;
                break;
                case 'Profesional':
                    return 0.666666667;
                break;
        }
        
    }

    public function getPonderacion()
    {
        $meses=$this->meses;
        if(empty($meses))
            return null;
        if($meses<12*16){
            return $this->notaBase+($meses/(12*16))*(1-$this->notaBase);
        }else{
            return 1;
        }
    }

    public function getMeses()
    {
        return $this->getExperiencias()->sum('meses');
    }
}
