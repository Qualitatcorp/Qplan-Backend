<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "evaluacion_alternativa".
 *
 * @property string $id
 * @property string $pre_id
 * @property integer $altenativa
 * @property double $poderacion
 * @property string $correcta
 *
 * @property EvaluacionPregunta $pre
 * @property FichaRespuesta[] $fichaRespuestas
 * @property FichaItem[] $fides
 */
class EvaluacionAlternativa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'evaluacion_alternativa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pre_id', 'altenativa'], 'required'],
            [['pre_id', 'altenativa'], 'integer'],
            [['poderacion'], 'number'],
            [['correcta'], 'string'],
            [['pre_id'], 'exist', 'skipOnError' => true, 'targetClass' => EvaluacionPregunta::className(), 'targetAttribute' => ['pre_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPre()
    {
        return $this->hasOne(EvaluacionPregunta::className(), ['id' => 'pre_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFichaRespuestas()
    {
        return $this->hasMany(FichaRespuesta::className(), ['alt_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFides()
    {
        return $this->hasMany(FichaItem::className(), ['id' => 'fide_id'])->viaTable('ficha_respuesta', ['alt_id' => 'id']);
    }
}
