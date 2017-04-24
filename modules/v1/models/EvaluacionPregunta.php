<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "evaluacion_pregunta".
 *
 * @property string $id
 * @property string $eva_id
 * @property string $pregunta
 * @property string $comentario
 * @property string $creado
 * @property string $modificado
 * @property string $habilitado
 *
 * @property EvaluacionAlternativa[] $evaluacionAlternativas
 * @property EvaluacionTeorica $eva
 * @property Recursos $recursos
 */
class EvaluacionPregunta extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'evaluacion_pregunta';
    }

    public function rules()
    {
        return [
            [['eva_id', 'pregunta'], 'required'],
            [['eva_id'], 'integer'],
            [['pregunta', 'comentario', 'habilitado'], 'string'],
            [['creado', 'modificado'], 'safe'],
            [['eva_id'], 'exist', 'skipOnError' => true, 'targetClass' => EvaluacionTeorica::className(), 'targetAttribute' => ['eva_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'eva_id' => 'Eva ID',
            'pregunta' => 'Pregunta',
            'comentario' => 'Comentario',
            'creado' => 'Creado',
            'modificado' => 'Modificado',
            'habilitado' => 'Habilitado',
        ];
    }

    // public function fields()
    // {
    //     $fields = parent::fields();
    //     array_push($fields, 'alternativas','recursos');
    //     return $fields;
    // }

    public function extraFields()
    {
        return ['alternativas','evaluacion','recursos'];
    }

    public function getAlternativas()
    {
        return $this->hasMany(EvaluacionAlternativa::className(), ['pre_id' => 'id']);
    }

    public function getEvaluacion()
    {
        return $this->hasOne(EvaluacionTeorica::className(), ['id' => 'eva_id']);
    }

    public function getRecursos()
    {
        return $this->hasOne(Recursos::className(), ['pre_id' => 'id']);
    }
}
