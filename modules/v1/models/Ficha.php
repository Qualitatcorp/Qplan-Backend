<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "ficha".
 *
 * @property string $id
 * @property string $ot_id
 * @property string $tra_id
 * @property string $proceso
 * @property string $creacion
 *
 * @property OrdenTrabajo $ot
 * @property Trabajador $tra
 * @property FichaPractica[] $fichaPracticas
 * @property PerfilModulo[] $mods
 */
class Ficha extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'ficha';
    }


    public function rules()
    {
        return [
            [['ot_id', 'tra_id'], 'required'],
            [['ot_id', 'tra_id'], 'integer'],
            [['proceso'], 'string'],
            [['creacion'], 'safe'],
            // [['ot_id', 'tra_id'], 'unique', 'targetAttribute' => ['ot_id', 'tra_id'], 'message' => 'The combination of Ot ID and Tra ID has already been taken.'],
            [['ot_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrdenTrabajo::className(), 'targetAttribute' => ['ot_id' => 'id']],
            [['tra_id'], 'exist', 'skipOnError' => true, 'targetClass' => Trabajador::className(), 'targetAttribute' => ['tra_id' => 'id']],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ot_id' => 'Ot ID',
            'tra_id' => 'Tra ID',
            'proceso' => 'Proceso',
            'creacion' => 'Creacion',
        ];
    }

    public function extraFields()
    {
        return ['ot','trabajador','ficpracticas','modulos','ficpracticas','ficteoricas','ficcurricular','modtercero','avgpractica','avgteorica','notas'];
    }

    public function getOt()
    {
        return $this->hasOne(OrdenTrabajo::className(), ['id' => 'ot_id']);
    }

    public function getModtercero()
    {
        return PerfilModulo::findBySql("SELECT * FROM perfil_modulo WHERE per_id IN (SELECT perfil.id FROM perfil INNER JOIN orden_trabajo ON (perfil.id = orden_trabajo.per_id) WHERE orden_trabajo.id=:id) AND FIND_IN_SET('TERCERO',evaluacion)>0",[':id'=>$this->ot_id])->all();
    }

    public function getTrabajador()
    {
        return $this->hasOne(Trabajador::className(), ['id' => 'tra_id']);
    }

    public function getFicpracticas()
    {
        return $this->hasMany(FichaPractica::className(), ['fic_id' => 'id']);
    }    
    public function getFicteoricas()
    {
        return $this->hasMany(FichaTeorico::className(), ['fic_id' => 'id']);
    }

    public function getModulos()
    {
        return $this->hasMany(PerfilModulo::className(), ['id' => 'mod_id'])->viaTable('ficha_practica', ['fic_id' => 'id']);
    }

    public function getAvgpractica()
    {
        if(in_array("FINALIZADO PRACTICA",explode(',',$this->proceso))){
            return $this->getFicpracticas()->average('nota');
        }else{
            return null;
        }
    }

    public function getAvgteorica()
    {
        if(in_array("FINALIZADO TEORICO",explode(',',$this->proceso))){
            $fts = $this->getFicteoricas()->where('nota IS NULL')->all();
            foreach ($fts as $ft) {
                $ft->nota=(empty($ft->puntajeAcierto))?0:$ft->puntajeAcierto;
                $ft->save();
            }
            return $this->getFicteoricas()->average('nota');
        }else{
            return null;
        }
    }

    public function getFiccurricular()
    {
        return $this->hasOne(FichaCurricular::className(), ['fic_id' => 'id']);
    }

    public function getNotas()
    {
        $list=[];
        $nota=$this->avgpractica;
        if(!empty($nota)){
            $list['practica']=(float)$nota;
        }
        $nota=$this->avgteorica;
        if(!empty($nota)){
            $list['teorica']=(float)$nota;
        }
        $nota=$this->ficcurricular;
        if(!empty($nota)){
            $list['curricular']=(float)$nota->nota;
        }

        return $list;
    }


}
