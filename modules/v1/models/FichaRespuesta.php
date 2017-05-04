<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "ficha_respuesta".
 *
 * @property string $id
 * @property string $fict_id
 * @property string $alt_id
 * @property string $creado
 *
 * @property EvaluacionAlternativa $alt
 * @property FichaTeorico $fict
 */
class FichaRespuesta extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'ficha_respuesta';
    }


    public function rules()
    {
        return [
            [['fict_id'], 'required'],
            [['fict_id', 'alt_id'], 'integer'],
            [['creado'], 'safe'],
            // [['alt_id'], 'exist', 'skipOnError' => true, 'targetClass' => EvaluacionAlternativa::className(), 'targetAttribute' => ['alt_id' => 'id']],
            [['fict_id'], 'exist', 'skipOnError' => true, 'targetClass' => FichaTeorico::className(), 'targetAttribute' => ['fict_id' => 'id']],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fict_id' => 'Fict ID',
            'alt_id' => 'Alt ID',
            'creado' => 'Creado',
        ];
    }

    public function getAlt()
    {
        return $this->hasOne(EvaluacionAlternativa::className(), ['id' => 'alt_id']);
    }

    public function getFict()
    {
        return $this->hasOne(FichaTeorico::className(), ['id' => 'fict_id']);
    }
}
