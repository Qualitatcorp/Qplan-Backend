<?php

namespace app\models\user;

use Yii;

class Authorization extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'user_authorization';
    }

    public function rules()
    {
        return [
            [['user_id', 'res_id'], 'required'],
            [['user_id', 'res_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['res_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserResource::className(), 'targetAttribute' => ['res_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'res_id' => 'Res ID',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getResources()
    {
        return $this->hasOne(UserResource::className(), ['id' => 'res_id']);
    }
}
