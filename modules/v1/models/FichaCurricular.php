<?php

namespace app\modules\v1\models;

use Yii;

class FichaCurricular extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ficha_curricular';
    }

    public function rules()
    {
        return [
            [['fic_id', 'nota'], 'required'],
            [['fic_id', 'user_id'], 'integer'],
            [['nota'], 'number'],
            [['creado'], 'safe'],
            [['fic_id'], 'unique'],
            [['fic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ficha::className(), 'targetAttribute' => ['fic_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'Nota Curricular',
            'fic_id' => 'Ficha',
            'user_id' => 'Usuario',
            'nota' => 'Nota Curricular',
            'creado' => 'Fecha de Creación',
        ];
    }

    public function getFicha()
    {
        return $this->hasOne(Ficha::className(), ['id' => 'fic_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
