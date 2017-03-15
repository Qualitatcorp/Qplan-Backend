<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "comuna".
 *
 * @property integer $com_id
 * @property string $nombre
 * @property integer $pro_id
 *
 * @property ComunaProvincia $pro
 * @property Empresa[] $empresas
 * @property Test[] $tests
 * @property Trabajador[] $trabajadors
 */
class Comuna extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comuna';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['com_id'], 'required'],
            [['com_id', 'pro_id'], 'integer'],
            [['nombre'], 'string', 'max' => 20],
            [['pro_id'], 'exist', 'skipOnError' => true, 'targetClass' => ComunaProvincia::className(), 'targetAttribute' => ['pro_id' => 'pro_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'com_id' => 'Com ID',
            'nombre' => 'Nombre',
            'pro_id' => 'Pro ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPro()
    {
        return $this->hasOne(ComunaProvincia::className(), ['pro_id' => 'pro_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresas()
    {
        return $this->hasMany(Empresa::className(), ['com_id' => 'com_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTests()
    {
        return $this->hasMany(Test::className(), ['comuna' => 'com_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrabajadors()
    {
        return $this->hasMany(Trabajador::className(), ['com_id' => 'com_id']);
    }
}
