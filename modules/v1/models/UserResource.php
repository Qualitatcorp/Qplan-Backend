<?php

namespace app\modules\v1\models;

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
 * @property UserResource[] $children
 * @property UserResource[] $parents
 */
class UserResource extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_resource';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['resource'], 'required'],
            [['resource'], 'string', 'max' => 128],
            [['resource'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'resource' => 'Resource',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAuthorizations()
    {
        return $this->hasMany(UserAuthorization::className(), ['res_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('user_authorization', ['res_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserResourceChildrens()
    {
        return $this->hasMany(UserResourceChildren::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserResourceChildrens0()
    {
        return $this->hasMany(UserResourceChildren::className(), ['child_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(UserResource::className(), ['id' => 'child_id'])->viaTable('user_resource_children', ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParents()
    {
        return $this->hasMany(UserResource::className(), ['id' => 'parent_id'])->viaTable('user_resource_children', ['child_id' => 'id']);
    }
}
