<?php

namespace app\modules\v1\models;

use Yii;

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
            [['nota'], 'number'],
            [['creacion'], 'safe'],
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
            'nota' => 'Nota',
            'creacion' => 'Creacion',
        ];
    }

    public function extraFields()
    {
        return [
        'ot',
        'trabajador',
        'ficpracticas',
        'modulos',
        'ficpracticas',
        'ficteoricas',
        'ficcurricular',
        'fictercero',
        'modtercero',
        'avgpractica',
        'avgteorica',
        'notatecnica',
        'notas',
        'final'
        ];
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
    public function getFictercero()
    {
        return $this->hasMany(FichaTercero::className(), ['fic_id' => 'id']);
    }

    public function getModulos()
    {
        return PerfilModulo::findBySql("SELECT * FROM perfil_modulo WHERE per_id IN (SELECT per_id FROM orden_trabajo WHERE id=:id)",[':id'=>$this->ot_id])->all();
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
        }else{
            $p=$this->trabajador->ponderacion;
            if(!empty($p)){
                $list['curricular']=(float)$p;
            }
        }
        $tercero=$this->fictercero;
        if(!empty($tercero)){
            foreach ($tercero as $model) {
                $modulo=$model->modulo;
                if($modulo->nivel="PRIMARIO"){
                    $list['tercero'][$model->modulo->nombre]=(float)$model->nota;
                }else{
                    if($modulo->nivel="SECUNDARIO"){
                        if(empty($list['tercero'][$model->modulo->nombre])){
                            $list['tercero'][$model->modulo->nombre]=$model->nota;
                        }
                        $list['tercero'][$model->modulo->nombre]+=",".$model->nota;
                    }   
                }
            }
        }
        return $list;
    }

    public function getFinal()
    {
        if(empty($this->nota)){
            if(strpos($this->proceso,"TERMINADO")!==false){
                $valores=array();
                // \Underscore\Types\Arrays::

                $notas=$this->notas;
                foreach ($notas as $n) {
                    if(is_numeric($n)){
                        $valores[]=$n;
                    }else{
                        if(is_array($n)){
                            foreach ($n as $key => $value) {
                                $valores[]=$value;
                            }
                        }
                    }
                }
                $sum=\Underscore\Types\Arrays::sum($valores);
                $this->nota=(float)$sum/count($valores);
                $this->save();
                return $this->nota;
                
            }else{

            }
        }else{
            return $this->nota;
        }
    }

    public function getCrossTecnica()
    {
        $modulos=$this->ot->perfil->getModulos()->where("FIND_IN_SET('TEORICA',evaluacion)>0 OR FIND_IN_SET('PRACTICA',evaluacion)>0")->All();
        $practica=$this->ficpracticas;
        $teorica=$this->ficteoricas;
        //variables de almacenamiento
        $notasModulos = array();
        //Cruzar
        foreach ($modulos as $mod) {
            $pra=null;
            foreach ($practica as $p) {
                if($mod->id==$p->mod_id){
                    $pra=$p;
                    break;
                }
            }
            $teo=null;
            foreach ($teorica as $p) {
                if($mod->id==$p->mod_id){
                    $teo=$p;
                    break;
                }
            }
            $notasModulos[]=[
                'modulo'=>$mod,
                'practica'=>$pra,
                'teorica'=>$teo
            ];
        }
        return $notasModulos;
    }

    public function getNotatecnica()
    {
        $sum=0;
        $total=0;
        //Calcular
        foreach ($this->crossTecnica as $nMod) {
            $total+=$nMod['modulo']->ponderacion;
            if(!empty($nMod['practica'])){
                if(!empty($nMod['teorica'])){
                    $sum+=(float)$nMod['modulo']->ponderacion*(($nMod['practica']->nota+$nMod['teorica']->nota)/2);
                }else{
                    $sum+=(float)$nMod['modulo']->ponderacion*$nMod['practica']->nota;
                }
            }else{
                if(!empty($nMod['teorica'])){
                    $sum+=(float)$nMod['modulo']->ponderacion*$nMod['teorica']->nota;
                }else{

                }
            }
        }
        return (float)$sum/$total;
    }
}
