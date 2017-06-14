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
        'notaTecnica',
        'notaCurricular',
        'notasTercera',
        'notaFinal',
        'notas'
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
        $nota=$this->notatecnica;
        if(!empty($nota)){
            $list['tecnica']=(float)$nota;
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

    public function getCrossTecnica()
    {
        $modulos=$this->ot->perfil->getModulos()->where("FIND_IN_SET('TEORICA',evaluacion)>0 OR FIND_IN_SET('PRACTICA',evaluacion)>0")->All();
        $practica=$this->ficpracticas;
        $teorica=$this->ficteoricas;
        //variables de almacenamiento
        $notasModulos = array();
        //Cruzar
        foreach ($modulos as $mod) {
            $pra = null;
            foreach ($practica as $p) {
                if($mod->id==$p->mod_id){
                    $pra=$p;
                    break;
                }
            }
            $teo = null;
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

    public function getNotaCurricular()
    {
        $nota=$this->ficcurricular;
        if(!empty($nota)){
            return (float)$nota->nota;
        }else{
            $p=$this->trabajador->ponderacion;
            if(!empty($p)){
                return (float)$p;
            }
        }
    }

    public function getNotaTecnica()
    {
        $sum=0;$total=0;
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
                    return;
                }
            }
        }
        return (float)$sum/$total;
    }

    public function getnNotaFinal()
    {
        $sum=0;$total=0;
        if(empty($this->nota)){
            if(strpos($this->proceso,"TERMINADO")!==false){
                $sum+=$this->notaTecnica;
                $total+=1;
                $fCur=$this->ficcurricular;
                if(!empty($fCur)){
                    $sum+=$fCur->ponderacion*$fCur->nota;
                    $total+=$fCur->ponderacion;
                }else{
                    $sum+=$this->notaCurricular;
                    $total+=1;
                }
                foreach ($this->crossTercera as $cTer) {
                    $sum+=(float)$cTer['modulo']['ponderacion']*(float)$cTer['nota'];
                    $total+=(float)$cTer['modulo']['ponderacion'];
                }
                $this->nota=(float)$sum/$total;
                $this->save();
                return (float)$this->nota;
            }else{
                return "PROCESO NO TERMINADO";
            }
        }else{
            return  (float)$this->nota;
        }
    }

    public function getCrossTercera()
    {
        return $this->getFictercero()->with('modulo')->asArray()->All();
    }

    public function getNotasTercera()
    {
        $list=[];
        foreach ($this->crossTercera as $cTer) {
            $list[$cTer['modulo']['nombre']]=(float)$cTer['nota'];
        }
        return $list;
    }
}
