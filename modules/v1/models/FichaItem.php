<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "ficha_item".
 *
 * @property string $id
 * @property string $ite_id
 * @property string $teo_id
 * @property string $nota
 *
 * @property EvaluacionItem $ite
 * @property FichaTeorico $teo
 * @property FichaRespuesta[] $fichaRespuestas
 * @property EvaluacionAlternativa[] $alts
 */
class FichaItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ficha_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ite_id', 'teo_id'], 'required'],
            [['ite_id', 'teo_id'], 'integer'],
            [['nota'], 'number'],
            [['ite_id', 'teo_id'], 'unique', 'targetAttribute' => ['ite_id', 'teo_id'], 'message' => 'The combination of Ite ID and Teo ID has already been taken.'],
            [['ite_id'], 'exist', 'skipOnError' => true, 'targetClass' => EvaluacionItem::className(), 'targetAttribute' => ['ite_id' => 'id']],
            [['teo_id'], 'exist', 'skipOnError' => true, 'targetClass' => FichaTeorico::className(), 'targetAttribute' => ['teo_id' => 'id']],
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
            'teo_id' => 'Teo ID',
            'nota' => 'Nota',
        ];
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
    public function getTeo()
    {
        return $this->hasOne(FichaTeorico::className(), ['id' => 'teo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFichaRespuestas()
    {
        return $this->hasMany(FichaRespuesta::className(), ['fide_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlts()
    {
        return $this->hasMany(EvaluacionAlternativa::className(), ['id' => 'alt_id'])->viaTable('ficha_respuesta', ['fide_id' => 'id']);
    }
}
