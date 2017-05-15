<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "ficha_practica".
 *
 * @property string $id
 * @property string $mod_id
 * @property string $fic_id
 * @property integer $eva_id
 * @property string $nota
 *
 * @property PerfilModulo $mod
 * @property Ficha $fic
 */
class FichaPractica extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'ficha_practica';
    }


    public function rules()
    {
        return [
            [['mod_id', 'fic_id', 'nota'], 'required'],
            [['mod_id', 'fic_id', 'eva_id'], 'integer'],
            [['nota'], 'number'],
            [['mod_id', 'fic_id'], 'unique', 'targetAttribute' => ['mod_id', 'fic_id'], 'message' => 'The combination of Mod ID and Fic ID has already been taken.'],
            [['mod_id'], 'exist', 'skipOnError' => true, 'targetClass' => PerfilModulo::className(), 'targetAttribute' => ['mod_id' => 'id']],
            [['fic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ficha::className(), 'targetAttribute' => ['fic_id' => 'id']],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mod_id' => 'Mod ID',
            'fic_id' => 'Fic ID',
            'eva_id' => 'Eva ID',
            'nota' => 'Nota',
        ];
    }

    public function getMod()
    {
        return $this->hasOne(PerfilModulo::className(), ['id' => 'mod_id']);
    }

    public function getFic()
    {
        return $this->hasOne(Ficha::className(), ['id' => 'fic_id']);
    }
}
