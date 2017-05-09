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
        return [
        'modulos',
        'modprimario',
        'modsecundario',
        'modpractica',
        'modteorica',
        'pet',
        'rhs',
        'rho',
        'evateorica',
        'preguntas',
        'alternativas',
        'recursos',
        'sources',
        'options',
        'ots',
        'cats'
        ];
    }

    // public function getClasificacionPerfils()
    // {
    //     return $this->hasMany(ClasificacionPerfil::className(), ['per_id' => 'id']);
    // }

    public function getClasificacion()
    {
        return $this->hasMany(Clasificacion::className(), ['id' => 'cla_id'])->viaTable('clasificacion_perfil', ['per_id' => 'id']);
    }

    public function getEmpresaClasificacion()
    {
        return $this->hasMany(EmpresaClasificacion::className(), ['per_id' => 'id']);
    }

    public function getOts()
    {
        return $this->hasMany(OrdenTrabajo::className(), ['per_id' => 'id']);
    }

    // public function getPerfilEspecialidades()
    // {
    //     return $this->hasMany(PerfilEspecialidad::className(), ['per_id' => 'id']);
    // }

    public function getEspecialidades()
    {
        return $this->hasMany(Especialidad::className(), ['id' => 'esp_id'])
        ->viaTable('perfil_especialidad', ['per_id' => 'id']);
    }

    public function getModulos()
    {
        return $this->hasMany(PerfilModulo::className(), ['per_id' => 'id']);
    }

    public function getModprimario()
    {
        return $this->hasMany(PerfilModulo::className(), ['per_id' => 'id'])->where(['nivel'=>'PRIMARIO']);
    }

    public function getModsecundario()
    {
        return $this->hasMany(PerfilModulo::className(), ['per_id' => 'id'])->where(['nivel'=>'SECUNDARIO']);
    }

    public function getModpractica()
    {
        return PerfilModulo::findBySql("SELECT * FROM perfil_modulo WHERE FIND_IN_SET('PRACTICA',evaluacion) AND per_id=:id",[':id'=>$this->id])->all();
    }

    public function getModteorica()
    {
        return PerfilModulo::findBySql("SELECT * FROM perfil_modulo WHERE FIND_IN_SET('TEORICA',evaluacion) AND per_id=:id",[':id'=>$this->id])->all();
        // return $this->hasMany(PerfilModulo::className(), ['per_id' => 'id'])->where(['like', 'evaluacion', 'TEORICA']);
    }

    public function getPet()
    {
        return PerfilEvaluacionTeorica::findBySql("SELECT perfil_evaluacion_teorica.* FROM perfil_evaluacion_teorica INNER JOIN perfil_modulo ON (perfil_evaluacion_teorica.mop_id = perfil_modulo.id) WHERE evaluacion LIKE '%TEORICA%' AND per_id = :id",[':id'=>$this->id])->all();
    }

    public function getEvateorica()
    {
        return EvaluacionTeorica::findBySql("SELECT evaluacion_teorica.* FROM perfil_evaluacion_teorica INNER JOIN perfil_modulo ON (perfil_evaluacion_teorica.mop_id = perfil_modulo.id) INNER JOIN evaluacion_teorica ON (perfil_evaluacion_teorica.evt_id = evaluacion_teorica.id) WHERE evaluacion LIKE '%TEORICA%' AND  per_id = :id",[':id'=>$this->id])->all();
    }

    public function getPreguntas()
    {
        return EvaluacionPregunta::findBySql("SELECT evaluacion_pregunta.* FROM perfil_evaluacion_teorica INNER JOIN perfil_modulo ON (perfil_evaluacion_teorica.mop_id = perfil_modulo.id) INNER JOIN evaluacion_teorica ON (perfil_evaluacion_teorica.evt_id = evaluacion_teorica.id) INNER JOIN evaluacion_pregunta ON (evaluacion_teorica.id = evaluacion_pregunta.eva_id) WHERE evaluacion LIKE '%TEORICA%' AND per_id = :id",[':id'=>$this->id])->all();
    }

    public function getAlternativas()
    {
         return EvaluacionAlternativa::findBySql("SELECT evaluacion_alternativa.* FROM perfil_evaluacion_teorica INNER JOIN perfil_modulo ON (perfil_evaluacion_teorica.mop_id = perfil_modulo.id) INNER JOIN evaluacion_teorica ON (perfil_evaluacion_teorica.evt_id = evaluacion_teorica.id) INNER JOIN evaluacion_pregunta ON (evaluacion_teorica.id = evaluacion_pregunta.eva_id) INNER JOIN evaluacion_alternativa ON (evaluacion_pregunta.id = evaluacion_alternativa.pre_id) WHERE evaluacion LIKE '%TEORICA%' AND per_id = :id",[':id'=>$this->id])->all();
    }

    public function getRecursos()
    {
         return Recursos::findBySql("SELECT recursos.* FROM perfil_evaluacion_teorica INNER JOIN perfil_modulo ON (perfil_evaluacion_teorica.mop_id = perfil_modulo.id) INNER JOIN evaluacion_teorica ON (perfil_evaluacion_teorica.evt_id = evaluacion_teorica.id) INNER JOIN evaluacion_pregunta ON (evaluacion_teorica.id = evaluacion_pregunta.eva_id) INNER JOIN recursos ON (evaluacion_pregunta.id = recursos.pre_id) WHERE evaluacion LIKE '%TEORICA%' AND  per_id = :id",[':id'=>$this->id])->all();
    }

    public function getRhs()
    {
         return RecursosHasSources::findBySql("SELECT recursos_has_sources.* FROM perfil_evaluacion_teorica INNER JOIN perfil_modulo ON (perfil_evaluacion_teorica.mop_id = perfil_modulo.id) INNER JOIN evaluacion_teorica ON (perfil_evaluacion_teorica.evt_id = evaluacion_teorica.id) INNER JOIN evaluacion_pregunta ON (evaluacion_teorica.id = evaluacion_pregunta.eva_id) INNER JOIN recursos ON (evaluacion_pregunta.id = recursos.pre_id) INNER JOIN recursos_has_sources ON (recursos.id = recursos_has_sources.rec_id) WHERE evaluacion LIKE '%TEORICA%' AND per_id = :id",[':id'=>$this->id])->all();
    }

    public function getRho()
    {
         return RecursosHasOptions::findBySql("SELECT DISTINCT recursos_has_options.* FROM perfil_evaluacion_teorica INNER JOIN perfil_modulo ON (perfil_evaluacion_teorica.mop_id = perfil_modulo.id) INNER JOIN evaluacion_teorica ON (perfil_evaluacion_teorica.evt_id = evaluacion_teorica.id) INNER JOIN evaluacion_pregunta ON (evaluacion_teorica.id = evaluacion_pregunta.eva_id) INNER JOIN recursos ON (evaluacion_pregunta.id = recursos.pre_id) INNER JOIN recursos_has_options ON (recursos.id = recursos_has_options.rec_id) WHERE evaluacion LIKE '%TEORICA%' AND per_id = :id",[':id'=>$this->id])->all();
    }

    public function getSources()
    {
         return RecursosSources::findBySql("SELECT recursos_sources.* FROM perfil_evaluacion_teorica INNER JOIN perfil_modulo ON (perfil_evaluacion_teorica.mop_id = perfil_modulo.id) INNER JOIN evaluacion_teorica ON (perfil_evaluacion_teorica.evt_id = evaluacion_teorica.id) INNER JOIN evaluacion_pregunta ON (evaluacion_teorica.id = evaluacion_pregunta.eva_id) INNER JOIN recursos ON (evaluacion_pregunta.id = recursos.pre_id) INNER JOIN recursos_has_sources ON (recursos.id = recursos_has_sources.rec_id) INNER JOIN recursos_sources ON (recursos_has_sources.src_id = recursos_sources.id) WHERE evaluacion LIKE '%TEORICA%' AND per_id = :id",[':id'=>$this->id])->all();
    }    

    public function getOptions()
    {
         return RecursosOptions::findBySql("SELECT DISTINCT recursos_options.* FROM perfil_evaluacion_teorica INNER JOIN perfil_modulo ON (perfil_evaluacion_teorica.mop_id = perfil_modulo.id) INNER JOIN evaluacion_teorica ON (perfil_evaluacion_teorica.evt_id = evaluacion_teorica.id) INNER JOIN evaluacion_pregunta ON (evaluacion_teorica.id = evaluacion_pregunta.eva_id) INNER JOIN recursos ON (evaluacion_pregunta.id = recursos.pre_id) INNER JOIN recursos_has_options ON (recursos.id = recursos_has_options.rec_id) INNER JOIN recursos_options ON (recursos_has_options.opt_id = recursos_options.id) WHERE evaluacion LIKE '%TEORICA%' AND per_id = :id",[':id'=>$this->id])->all();
    }

    public function getCats()
    {
        return ClasificacionCategoria::findBySql("SELECT * FROM clasificacion_categoria WHERE clasificacion_categoria.id IN (SELECT clasificacion.cat_id FROM clasificacion INNER JOIN clasificacion_perfil ON (clasificacion.id = clasificacion_perfil.cla_id) WHERE clasificacion_perfil.per_id = :id)",[':id'=>$this->id])->all();
                       
    }





    // public function getAlternativas()
    // {
    //      return EvaluacionPregunta::findBySql(":id",[':id'=>$this->id])->all();
    // }





    // public function getEvaluacionteorica()
    // {
    //     return $this->hasMany(EvaluacionTeorica::ClassName(),['id'=>'evt_id'])->via('perfilevaluacionteorica');
    // }
}
