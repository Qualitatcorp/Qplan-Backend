<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "test".
 *
 * @property string $id
 * @property string $nombre
 * @property string $nacimiento
 * @property integer $hijos
 * @property string $civil
 * @property string $licencia
 * @property string $estatura
 * @property integer $comuna
 *
 * @property Comuna $comuna0
 */
class Test extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nacimiento', 'hijos', 'civil', 'licencia', 'estatura'], 'required'],
            [['nacimiento'], 'safe'],
            [['hijos', 'comuna'], 'integer'],
            [['civil', 'licencia'], 'string'],
            ['civil','in','range'=>['SOLTERO/A','CASADO/A','DIVORCIADO/A','SEPARADO','CONVIVIENTE'],'strict'=>true],
            [['estatura'], 'number'],
            [['nombre'], 'string', 'max' => 128],
            [['comuna'], 'exist', 'skipOnError' => true, 'targetClass' => Comuna::className(), 'targetAttribute' => ['comuna' => 'com_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'nacimiento' => 'Nacimiento',
            'hijos' => 'Hijos',
            'civil' => 'Civil',
            'licencia' => 'Licencia',
            'estatura' => 'Estatura',
            'comuna' => 'Comuna',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComuna0()
    {
        return $this->hasOne(Comuna::className(), ['com_id' => 'comuna']);
    }
}
