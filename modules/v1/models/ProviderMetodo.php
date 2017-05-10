<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "provider_metodo".
 *
 * @property string $id
 * @property string $pro_id
 * @property string $metodo
 * @property string $params
 * @property string $template
 *
 * @property Provider $pro
 */
class ProviderMetodo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'provider_metodo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pro_id', 'metodo'], 'required'],
            [['pro_id'], 'integer'],
            [['template'], 'string'],
            [['metodo'], 'string', 'max' => 128],
            [['params'], 'string', 'max' => 256],
            [['pro_id'], 'exist', 'skipOnError' => true, 'targetClass' => Provider::className(), 'targetAttribute' => ['pro_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pro_id' => 'Pro ID',
            'metodo' => 'Metodo',
            'params' => 'Params',
            'template' => 'Template',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPro()
    {
        return $this->hasOne(Provider::className(), ['id' => 'pro_id']);
    }
}
