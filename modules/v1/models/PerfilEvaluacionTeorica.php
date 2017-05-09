<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "perfil_evaluacion_teorica".
 *
 * @property string $id
 * @property string $evt_id
 * @property string $mop_id
 *
 * @property PerfilModulo $mop
 * @property EvaluacionTeorica $evt
 */
class PerfilEvaluacionTeorica extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'perfil_evaluacion_teorica';
    }


    public function rules()
    {
        return [
            [['evt_id', 'mop_id'], 'required'],
            [['evt_id', 'mop_id'], 'integer'],
            [['evt_id', 'mop_id'], 'unique', 'targetAttribute' => ['evt_id', 'mop_id'], 'message' => 'The combination of Evt ID and Mop ID has already been taken.'],
            [['mop_id'], 'exist', 'skipOnError' => true, 'targetClass' => PerfilModulo::className(), 'targetAttribute' => ['mop_id' => 'id']],
            [['evt_id'], 'exist', 'skipOnError' => true, 'targetClass' => EvaluacionTeorica::className(), 'targetAttribute' => ['evt_id' => 'id']],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'evt_id' => 'Evt ID',
            'mop_id' => 'Mop ID',
        ];
    }

    public function getMop()
    {
        return $this->hasOne(PerfilModulo::className(), ['id' => 'mop_id']);
    }

    public function getEvt()
    {
        return $this->hasOne(EvaluacionTeorica::className(), ['id' => 'evt_id']);
    }
}
