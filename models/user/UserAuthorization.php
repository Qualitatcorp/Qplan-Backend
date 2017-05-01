<?php

namespace app\models\user;

use Yii;

/**
 * This is the model class for table "user_authorization".
 *
 * @property string $user_id
 * @property integer $res_id
 *
 * @property User $user
 * @property UserResource $res
 */
class UserAuthorization extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_authorization';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'res_id'], 'required'],
            [['user_id', 'res_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['res_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserResource::className(), 'targetAttribute' => ['res_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'res_id' => 'Res ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRes()
    {
        return $this->hasOne(UserResource::className(), ['id' => 'res_id']);
    }
}
