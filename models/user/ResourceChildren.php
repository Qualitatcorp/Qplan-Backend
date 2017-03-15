<?php

namespace app\models\user;

use Yii;

/**
 * This is the model class for table "user_resource_children".
 *
 * @property integer $parent_id
 * @property integer $child_id
 *
 * @property UserResource $parent
 * @property UserResource $child
 */
class ResourceChildren extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_resource_children';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'child_id'], 'required'],
            [['parent_id', 'child_id'], 'integer'],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserResource::className(), 'targetAttribute' => ['parent_id' => 'id']],
            [['child_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserResource::className(), 'targetAttribute' => ['child_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parent_id' => 'Parent ID',
            'child_id' => 'Child ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(UserResource::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChild()
    {
        return $this->hasOne(UserResource::className(), ['id' => 'child_id']);
    }
}
