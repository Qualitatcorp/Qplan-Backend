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
 * @property FichaItem[] $fichaItems
 * @property EvaluacionItem[] $ites
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
    public function getFichaItems()
    {
        return $this->hasMany(FichaItem::className(), ['teo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItes()
    {
        return $this->hasMany(EvaluacionItem::className(), ['id' => 'ite_id'])->viaTable('ficha_item', ['teo_id' => 'id']);
    }
}
