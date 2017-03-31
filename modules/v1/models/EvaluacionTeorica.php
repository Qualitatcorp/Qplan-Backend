<?php

namespace app\modules\v1\models;

use Yii;

class EvaluacionTeorica extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'evaluacion_teorica';
    }

    public function rules()
    {
        return [
            [['tev_id', 'nombre'], 'required'],
            [['tev_id'], 'integer'],
            [['descripcion'], 'string'],
            [['nombre'], 'string', 'max' => 256],
            [['tev_id'], 'exist', 'skipOnError' => true, 'targetClass' => EvaluacionTipo::className(), 'targetAttribute' => ['tev_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tev_id' => 'Tev ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
        ];
    }
    
    public function extraFields()
    {
        return ['tipo','modulos','preguntas'];
    }

    public function getPreguntas()
    {
        return $this->hasMany(EvaluacionPregunta::className(), ['eva_id' => 'id']);
    }

    public function getTipo()
    {
        return $this->hasOne(EvaluacionTipo::className(), ['id' => 'tev_id']);
    }

    public function getPerfilEvaluacionTeoricas()
    {
        return $this->hasMany(PerfilEvaluacionTeorica::className(), ['evt_id' => 'id']);
    }

    public function getModulos()
    {
        return $this->hasMany(PerfilModulo::className(), ['id' => 'mop_id'])->viaTable('perfil_evaluacion_teorica', ['evt_id' => 'id']);
    }
}
