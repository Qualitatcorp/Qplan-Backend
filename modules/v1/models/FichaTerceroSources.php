<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "ficha_tercero_sources".
 *
 * @property string $id
 * @property string $fict_id
 * @property string $src_id
 * @property string $tipo
 *
 * @property FichaTercero $fict
 * @property RecursosSources $src
 */
class FichaTerceroSources extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ficha_tercero_sources';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fict_id', 'src_id'], 'required'],
            [['fict_id', 'src_id'], 'integer'],
            [['tipo'], 'string'],
            [['fict_id'], 'exist', 'skipOnError' => true, 'targetClass' => FichaTercero::className(), 'targetAttribute' => ['fict_id' => 'id']],
            [['src_id'], 'exist', 'skipOnError' => true, 'targetClass' => RecursosSources::className(), 'targetAttribute' => ['src_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fict_id' => 'Ficha Tercero',
            'src_id' => 'Recursos Sources',
            'tipo' => 'TIpo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFict()
    {
        return $this->hasOne(FichaTercero::className(), ['id' => 'fict_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSrc()
    {
        return $this->hasOne(RecursosSources::className(), ['id' => 'src_id']);
    }
}
