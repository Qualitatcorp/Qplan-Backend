<?php

namespace app\modules\v1\models;

use Yii;

class FichaTercero extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ficha_tercero';
    }

    public function rules()
    {
        return [
            [['fic_id', 'mod_id', 'prov_id', 'nota'], 'required'],
            [['fic_id', 'mod_id', 'prov_id'], 'integer'],
            [['nota'], 'number'],
            [['identity'], 'string', 'max' => 128],
            [['fic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ficha::className(), 'targetAttribute' => ['fic_id' => 'id']],
            [['mod_id'], 'exist', 'skipOnError' => true, 'targetClass' => PerfilModulo::className(), 'targetAttribute' => ['mod_id' => 'id']],
            [['prov_id'], 'exist', 'skipOnError' => true, 'targetClass' => Provider::className(), 'targetAttribute' => ['prov_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fic_id' => 'Fic ID',
            'mod_id' => 'Mod ID',
            'prov_id' => 'Prov ID',
            'nota' => 'Nota',
            'identity' => 'Identity',
        ];
    }

    public function getFicha()
    {
        return $this->hasOne(Ficha::className(), ['id' => 'fic_id']);
    }

    public function getModulo()
    {
        return $this->hasOne(PerfilModulo::className(), ['id' => 'mod_id']);
    }

    public function getProvider()
    {
        return $this->hasOne(Provider::className(), ['id' => 'prov_id']);
    }

    public function getSources()
    {
        return $this->hasMany(FichaTerceroSources::className(), ['fict_id' => 'id']);
    }
}
