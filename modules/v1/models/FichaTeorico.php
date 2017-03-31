<?php

namespace app\modules\v1\models;

use Yii;

class FichaTeorico extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'ficha_teorico';
    }

    public function rules()
    {
        return [
            [['mod_id', 'fic_id'], 'required'],
            [['mod_id', 'fic_id'], 'integer'],
            [['nota'], 'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mod_id' => 'Mod ID',
            'fic_id' => 'Fic ID',
            'nota' => 'Nota',
        ];
    }

    public function getFichaRespuestas()
    {
        return $this->hasMany(FichaRespuesta::className(), ['fict_id' => 'id']);
    }
}
