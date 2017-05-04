<?php

namespace app\modules\v1\models;

use Yii;

class UserResource extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'user_resource';
    }


    public function rules()
    {
        return [
            [['resource'], 'required'],
            [['resource'], 'string', 'max' => 128],
            [['resource'], 'unique'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'resource' => 'Resource',
        ];
    }

    public function extraFields()
    {
        return ['children','parents','users'];
    }

    public function getUserAuthorizations()
    {
        return $this->hasMany(UserAuthorization::className(), ['res_id' => 'id']);
    }

    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('user_authorization', ['res_id' => 'id']);
    }

    public function getUserResourceChildrens()
    {
        return $this->hasMany(UserResourceChildren::className(), ['parent_id' => 'id']);
    }

    public function getUserResourceChildrens0()
    {
        return $this->hasMany(UserResourceChildren::className(), ['child_id' => 'id']);
    }

    public function getChildren()
    {
        return $this->hasMany(UserResource::className(), ['id' => 'child_id'])->viaTable('user_resource_children', ['parent_id' => 'id']);
    }

    public function getParents()
    {
        return $this->hasMany(UserResource::className(), ['id' => 'parent_id'])->viaTable('user_resource_children', ['child_id' => 'id']);
    }
}
