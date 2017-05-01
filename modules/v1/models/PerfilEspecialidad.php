<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "perfil_especialidad".
 *
 * @property string $id
 * @property string $per_id
 * @property integer $esp_id
 *
 * @property Perfil $per
 * @property Especialidad $esp
 */
class PerfilEspecialidad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'perfil_especialidad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['per_id', 'esp_id'], 'required'],
            [['per_id', 'esp_id'], 'integer'],
            [['per_id', 'esp_id'], 'unique', 'targetAttribute' => ['per_id', 'esp_id'], 'message' => 'The combination of Per ID and Esp ID has already been taken.'],
            [['per_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perfil::className(), 'targetAttribute' => ['per_id' => 'id']],
            [['esp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Especialidad::className(), 'targetAttribute' => ['esp_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'per_id' => 'Per ID',
            'esp_id' => 'Esp ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPer()
    {
        return $this->hasOne(Perfil::className(), ['id' => 'per_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEsp()
    {
        return $this->hasOne(Especialidad::className(), ['id' => 'esp_id']);
    }
}
