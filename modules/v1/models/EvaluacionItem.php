<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "evaluacion_item".
 *
 * @property string $id
 * @property string $evt_id
 * @property string $tipo
 * @property string $influencia
 * @property string $metodo
 *
 * @property EvaluacionTeorica $evt
 * @property EvaluacionPregunta[] $evaluacionPreguntas
 * @property FichaItem[] $fichaItems
 * @property FichaTeorico[] $teos
 */
class EvaluacionItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'evaluacion_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['evt_id', 'tipo', 'influencia', 'metodo'], 'required'],
            [['evt_id'], 'integer'],
            [['tipo', 'influencia', 'metodo'], 'string'],
            [['evt_id', 'tipo'], 'unique', 'targetAttribute' => ['evt_id', 'tipo'], 'message' => 'The combination of Evt ID and Tipo has already been taken.'],
            [['evt_id'], 'exist', 'skipOnError' => true, 'targetClass' => EvaluacionTeorica::className(), 'targetAttribute' => ['evt_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'evt_id' => 'Evt ID',
            'tipo' => 'Tipo',
            'influencia' => 'Influencia',
            'metodo' => 'Metodo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvt()
    {
        return $this->hasOne(EvaluacionTeorica::className(), ['id' => 'evt_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvaluacionPreguntas()
    {
        return $this->hasMany(EvaluacionPregunta::className(), ['ite_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFichaItems()
    {
        return $this->hasMany(FichaItem::className(), ['ite_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeos()
    {
        return $this->hasMany(FichaTeorico::className(), ['id' => 'teo_id'])->viaTable('ficha_item', ['ite_id' => 'id']);
    }
}
