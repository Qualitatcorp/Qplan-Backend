<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "ficha_tercero".
 *
 * @property string $id
 * @property string $fic_id
 * @property string $mod_id
 * @property string $prov_id
 * @property string $nota
 * @property string $identity
 *
 * @property Ficha $fic
 * @property PerfilModulo $mod
 * @property Provider $prov
 * @property FichaTerceroSources[] $fichaTerceroSources
 */
class FichaTercero extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ficha_tercero';
    }

    /**
     * @inheritdoc
     */
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

    /**
     * @inheritdoc
     */
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFic()
    {
        return $this->hasOne(Ficha::className(), ['id' => 'fic_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMod()
    {
        return $this->hasOne(PerfilModulo::className(), ['id' => 'mod_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProv()
    {
        return $this->hasOne(Provider::className(), ['id' => 'prov_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFichaTerceroSources()
    {
        return $this->hasMany(FichaTerceroSources::className(), ['fict_id' => 'id']);
    }
}
