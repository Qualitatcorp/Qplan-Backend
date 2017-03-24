<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "user_client".
 *
 * @property string $client_id
 * @property string $secret
 * @property string $name
 * @property string $redirect
 *
 * @property UserAuthentication[] $userAuthentications
 */
class UserClient extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_client';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['secret', 'name'], 'string', 'max' => 64],
            [['redirect'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'client_id' => 'Client ID',
            'secret' => 'Secret',
            'name' => 'Name',
            'redirect' => 'Redirect',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAuthentications()
    {
        return $this->hasMany(UserAuthentication::className(), ['client_id' => 'client_id']);
    }
}
