<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "evaluacion_alternativa".
 *
 * @property string $id
 * @property string $pre_id
 * @property string $altenativa
 * @property double $poderacion
 * @property string $correcta
 *
 * @property EvaluacionPregunta $pre
 * @property FichaRespuesta[] $fichaRespuestas
 */
class EvaluacionAlternativa extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'evaluacion_alternativa';
    }


    public function rules()
    {
        return [
            [['pre_id', 'altenativa'], 'required'],
            [['pre_id'], 'integer'],
            [['altenativa', 'correcta'], 'string'],
            [['poderacion'], 'number'],
            [['pre_id'], 'exist', 'skipOnError' => true, 'targetClass' => EvaluacionPregunta::className(), 'targetAttribute' => ['pre_id' => 'id']],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pre_id' => 'Pre ID',
            'altenativa' => 'Altenativa',
            'poderacion' => 'Poderacion',
            'correcta' => 'Correcta',
        ];
    }

    public function getPre()
    {
        return $this->hasOne(EvaluacionPregunta::className(), ['id' => 'pre_id']);
    }

    public function getFichaRespuestas()
    {
        return $this->hasMany(FichaRespuesta::className(), ['alt_id' => 'id']);
    }
}
