<?php

namespace app\models\user;

use Yii;

/**
 * This is the model class for table "user_resource".
 *
 * @property integer $id
 * @property string $resource
 *
 * @property UserAuthorization[] $userAuthorizations
 * @property User[] $users
 * @property UserResourceChildren[] $userResourceChildrens
 * @property UserResourceChildren[] $userResourceChildrens0
 * @property Resource[] $children
 * @property Resource[] $parents
 */
class Resource extends \yii\db\ActiveRecord
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

    // public function fields()
    // {
    //     return ['resource'];
    // }

    // public function extraFields()
    // {
    //     return ['children'];
    // }

    public function getUserAuthorizations()
    {
        return $this->hasMany(UserAuthorization::className(), ['res_id' => 'id']);
    }
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('user_authorization', ['res_id' => 'id']);
    }
    public function getUserResourceParent()
    {
        return $this->hasMany(UserResourceChildren::className(), ['parent_id' => 'id']);
    }
    public function getUserResourceChildrens()
    {
        return $this->hasMany(UserResourceChildren::className(), ['child_id' => 'id']);
    }
    public function getChildren()
    {
        return $this->hasMany(Resource::className(), ['id' => 'child_id'])->viaTable('user_resource_children', ['parent_id' => 'id']);
    }    
    public function getChildren0()
    {
        return $this->hasMany(Resource::className(), ['id' => 'child_id'])->viaTable('user_resource_children', ['parent_id' => 'id']);
    }
    public function getParents()
    {
        return $this->hasMany(Resource::className(), ['id' => 'parent_id'])->viaTable('user_resource_children', ['child_id' => 'id']);
    }
}
