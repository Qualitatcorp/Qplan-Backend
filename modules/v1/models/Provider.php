<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "provider".
 *
 * @property string $id
 * @property string $nombre
 * @property string $descripcion
 * @property string $href
 *
 * @property FichaTercero[] $fichaTerceros
 * @property ProviderMetodo[] $providerMetodos
 */
class Provider extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'provider';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['descripcion', 'href'], 'string'],
            [['nombre'], 'string', 'max' => 128],
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
            'descripcion' => 'Descripcion',
            'href' => 'Href',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFichaTerceros()
    {
        return $this->hasMany(FichaTercero::className(), ['prov_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProviderMetodos()
    {
        return $this->hasMany(ProviderMetodo::className(), ['pro_id' => 'id']);
    }
}
