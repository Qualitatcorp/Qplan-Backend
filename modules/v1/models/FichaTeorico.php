<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "ficha_teorico".
 *
 * @property string $id
 * @property string $mod_id
 * @property string $fic_id
 * @property string $nota
 *
 * @property FichaRespuesta[] $fichaRespuestas
 */
class FichaTeorico extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ficha_teorico';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mod_id', 'fic_id'], 'required'],
            [['mod_id', 'fic_id'], 'integer'],
            [['nota'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mod_id' => 'Mod ID',
            'fic_id' => 'Fic ID',
            'nota' => 'Nota',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFichaRespuestas()
    {
        return $this->hasMany(FichaRespuesta::className(), ['fict_id' => 'id']);
    }
}
