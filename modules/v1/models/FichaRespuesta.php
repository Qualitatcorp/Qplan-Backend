<?php

namespace app\modules\v1\models;

use Yii;

class FichaRespuesta extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'ficha_respuesta';
    }

    public function rules()
    {
        return [
            [['fict_id', 'pre_id'], 'required'],
            [['fict_id', 'alt_id', 'pre_id'], 'integer'],
            [['creado'], 'safe'],
            [['alt_id'], 'exist', 'skipOnError' => true, 'targetClass' => EvaluacionAlternativa::className(), 'targetAttribute' => ['alt_id' => 'id']],
            [['fict_id'], 'exist', 'skipOnError' => true, 'targetClass' => FichaTeorico::className(), 'targetAttribute' => ['fict_id' => 'id']],
            [['pre_id'], 'exist', 'skipOnError' => true, 'targetClass' => EvaluacionPregunta::className(), 'targetAttribute' => ['pre_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fict_id' => 'Ficha Teorica',
            'alt_id' => 'Alternativa',
            'pre_id' => 'Pregunta',
            'creado' => 'Creado',
        ];
    }

    public function getAlternativa()
    {
        return $this->hasOne(EvaluacionAlternativa::className(), ['id' => 'alt_id']);
    }

    public function getFict()
    {
        return $this->hasOne(FichaTeorico::className(), ['id' => 'fict_id']);
    }

    public function getPregunta()
    {
        return $this->hasOne(EvaluacionPregunta::className(), ['id' => 'pre_id']);
    }
}
