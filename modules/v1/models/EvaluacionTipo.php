<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "evaluacion_tipo".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 *
 * @property EvaluacionTeorica[] $evaluacionTeoricas
 */
class EvaluacionTipo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'evaluacion_tipo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['descripcion'], 'string'],
            [['nombre'], 'string', 'max' => 128],
            [['nombre'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvaluacionTeoricas()
    {
        return $this->hasMany(EvaluacionTeorica::className(), ['tev_id' => 'id']);
    }
}
