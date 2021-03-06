<?php

namespace app\models\user;

use Yii;

use yii\web\HttpException;

class Authentication extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'user_authentication';
    }
    public function rules()
    {
        return [
            [['token', 'expire', 'user_id', 'client_id'], 'required'],
            [['start', 'expire', 'user_id', 'client_id'], 'integer'],
            [['token', 'refresh'], 'string', 'max' => 32],
            [['refresh'], 'unique'],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::className(), 'targetAttribute' => ['client_id' => 'client_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'token' => 'Token',
            'refresh' => 'Refresh',
            'start' => 'Start',
            'expire' => 'Expire',
            'user_id' => 'User ID',
            'client_id' => 'Client ID',
        ];
    }

    public static function GrantAccess($userId,$clientId,$expire_in,$refresh=false)
    {
        for ($i=0; $i < 5; $i++) {
            $model=new Authentication();
            $model->attributes=[
                'token'=>\Yii::$app->security->generateRandomString(),
                'refresh'=>($refresh)?\Yii::$app->security->generateRandomString():null,
                'start'=>time(),
                'expire'=>time()+$expire_in,
                'user_id'=>$userId,
                'client_id'=>$clientId
            ];
            if($model->save()){
                return $model;
            }
        }
        throw new HttpException(401, "Error en credenciales intentelo denuevo.");
    }

    public static function findAccessToken($token)
    {
        return static::find()
            ->where(['token'=>$token])
            ->andWhere(['>','expire',time()])
            ->one();
    }

    public static function findRefresh($refresh)
    {
        return static::find()
            ->where(['refresh'=>$refresh])
            ->andWhere(['>','expire',time()])
            ->one();
    }

    public function Renovate($expire_in=3600)
    {
        $this->expire=time()+$expire_in;
        $this->refresh=\Yii::$app->security->generateRandomString();
        while(!$this->save()){
            $this->refresh=\Yii::$app->security->generateRandomString();
        }
        return $expire_in;
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
