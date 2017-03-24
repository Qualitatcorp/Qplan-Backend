<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "ficha_respuesta".
 *
 * @property string $id
 * @property string $fide_id
 * @property string $alt_id
 * @property string $creado
 *
 * @property FichaItem $fide
 * @property EvaluacionAlternativa $alt
 */
class FichaRespuesta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ficha_respuesta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fide_id', 'alt_id'], 'required'],
            [['fide_id', 'alt_id'], 'integer'],
            [['creado'], 'safe'],
            [['fide_id', 'alt_id'], 'unique', 'targetAttribute' => ['fide_id', 'alt_id'], 'message' => 'The combination of Fide ID and Alt ID has already been taken.'],
            [['fide_id'], 'exist', 'skipOnError' => true, 'targetClass' => FichaItem::className(), 'targetAttribute' => ['fide_id' => 'id']],
            [['alt_id'], 'exist', 'skipOnError' => true, 'targetClass' => EvaluacionAlternativa::className(), 'targetAttribute' => ['alt_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fide_id' => 'Fide ID',
            'alt_id' => 'Alt ID',
            'creado' => 'Creado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFide()
    {
        return $this->hasOne(FichaItem::className(), ['id' => 'fide_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlt()
    {
        return $this->hasOne(EvaluacionAlternativa::className(), ['id' => 'alt_id']);
    }
}
