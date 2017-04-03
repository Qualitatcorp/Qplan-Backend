<?php

namespace app\modules\v1\models;

use Yii;

class PerfilModulo extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'perfil_modulo';
    }

    public function rules()
    {
        return [
            [['per_id', 'nombre', 'evaluacion'], 'required'],
            [['per_id'], 'integer'],
            [['nivel', 'evaluacion'], 'string'],
            [['ponderacion'], 'number'],
            [['nombre'], 'string', 'max' => 256],
            [['per_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perfil::className(), 'targetAttribute' => ['per_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'per_id' => 'Per ID',
            'nombre' => 'Nombre',
            'nivel' => 'Nivel',
            'evaluacion' => 'Evaluacion',
            'ponderacion' => 'Ponderacion',
        ];
    }

    public function fields()
    {
        $fields = parent::fields();
        array_push($fields, 'evaluaciones');
        return $fields;
    }

    public function extraFields()
    {
        return ['evaluacionteorica','perfil','fichas'];
    }

    public function getFichaPracticas()
    {
        return $this->hasMany(FichaPractica::className(), ['mod_id' => 'id']);
    }

    public function getFichas()
    {
        return $this->hasMany(Ficha::className(), ['id' => 'fic_id'])->viaTable('ficha_practica', ['mod_id' => 'id']);
    }

    // public function getPerfilEvaluacionTeoricas()
    // {
    //     return $this->hasMany(PerfilEvaluacionTeorica::className(), ['mop_id' => 'id']);
    // }

    public function getEvaluaciones()
    {
        return $this->hasMany(EvaluacionTeorica::className(), ['id' => 'evt_id'])->viaTable('perfil_evaluacion_teorica', ['mop_id' => 'id']);
    }

    public function getPerfil()
    {
        return $this->hasOne(Perfil::className(), ['id' => 'per_id']);
    }
}
