<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "user_authentication".
 *
 * @property string $token
 * @property string $refresh
 * @property string $expire
 * @property string $user_id
 * @property string $client_id
 *
 * @property UserClient $client
 * @property User $user
 */
class UserAuthentication extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'user_authentication';
    }


    public function rules()
    {
        return [
            [['token', 'expire', 'user_id', 'client_id'], 'required'],
            [['expire', 'user_id', 'client_id'], 'integer'],
            [['token', 'refresh'], 'string', 'max' => 32],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserClient::className(), 'targetAttribute' => ['client_id' => 'client_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }


    public function attributeLabels()
    {
        return [
            'token' => 'Token',
            'refresh' => 'Refresh',
            'expire' => 'Expire',
            'user_id' => 'User ID',
            'client_id' => 'Client ID',
        ];
    }

    public function getClient()
    {
        return $this->hasOne(UserClient::className(), ['client_id' => 'client_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
