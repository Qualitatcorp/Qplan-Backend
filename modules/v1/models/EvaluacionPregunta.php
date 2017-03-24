<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "evaluacion_pregunta".
 *
 * @property string $id
 * @property string $ite_id
 * @property string $pregunta
 * @property string $comentario
 * @property string $creado
 * @property string $modificado
 * @property string $habilitado
 *
 * @property EvaluacionAlternativa[] $evaluacionAlternativas
 * @property EvaluacionItem $ite
 * @property Recursos $recursos
 */
class EvaluacionPregunta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'evaluacion_pregunta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ite_id', 'pregunta'], 'required'],
            [['ite_id'], 'integer'],
            [['pregunta', 'comentario', 'habilitado'], 'string'],
            [['creado', 'modificado'], 'safe'],
            [['ite_id'], 'exist', 'skipOnError' => true, 'targetClass' => EvaluacionItem::className(), 'targetAttribute' => ['ite_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ite_id' => 'Ite ID',
            'pregunta' => 'Pregunta',
            'comentario' => 'Comentario',
            'creado' => 'Creado',
            'modificado' => 'Modificado',
            'habilitado' => 'Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvaluacionAlternativas()
    {
        return $this->hasMany(EvaluacionAlternativa::className(), ['pre_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIte()
    {
        return $this->hasOne(EvaluacionItem::className(), ['id' => 'ite_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecursos()
    {
        return $this->hasOne(Recursos::className(), ['pre_id' => 'id']);
    }
}
