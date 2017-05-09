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

    public static function tableName()
    {
        return 'evaluacion_tipo';
    }


    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['descripcion'], 'string'],
            [['nombre'], 'string', 'max' => 128],
            [['nombre'], 'unique'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
        ];
    }

    public function getEvaluacionTeoricas()
    {
        return $this->hasMany(EvaluacionTeorica::className(), ['tev_id' => 'id']);
    }
}
