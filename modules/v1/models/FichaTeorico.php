<?php

namespace app\modules\v1\models;

use Yii;

class FichaTeorico extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ficha_teorico';
    }

    public function rules()
    {
        return [
            [['mod_id', 'fic_id'], 'required'],
            [['mod_id', 'fic_id'], 'integer'],
            [['nota'], 'number'],
            [['fic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ficha::className(), 'targetAttribute' => ['fic_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mod_id' => 'Mod ID',
            'fic_id' => 'Fic ID',
            'nota' => 'Nota',
        ];
    }

    public function extraFields()
    {
        return [
            'puntajeTotal',
            'puntajeCorrecto',
            'puntajeAcierto',
            'respuestas',
            'preguntas',
            'alternativas'
        ];
    }
    public function getRespuestas()
    {
        return $this->hasMany(FichaRespuesta::className(), ['fict_id' => 'id']);
    }

    public function getAlternativas()
    {
        return $this->hasMany(EvaluacionAlternativa::className(),['id'=>'alt_id'])->via('respuestas');
    }

    public function getPreguntas()
    {
        return $this->hasMany(EvaluacionPregunta::className(),['id'=>'pre_id'])->via('respuestas');
    }

    public function getPuntajeAcierto()
    {
        return $this->puntajeCorrecto/$this->puntajeTotal;
    }

    public function getPuntajeTotal()
    {
        return $this->getPreguntas()->sum('ponderacion');
    }

    public function getPuntajeCorrecto()
    {
        return $this->getAlternativas()
            ->innerJoin('evaluacion_pregunta','evaluacion_alternativa.pre_id=evaluacion_pregunta.id')
            ->where(['correcta'=>'SI'])
            ->sum('evaluacion_pregunta.ponderacion*evaluacion_alternativa.ponderacion');
    }
}
