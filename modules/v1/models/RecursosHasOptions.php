<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "recursos_has_options".
 *
 * @property string $id
 * @property string $rec_id
 * @property string $opt_id
 *
 * @property Recursos $rec
 * @property RecursosOptions $opt
 */
class RecursosHasOptions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recursos_has_options';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rec_id', 'opt_id'], 'required'],
            [['rec_id', 'opt_id'], 'integer'],
            [['rec_id', 'opt_id'], 'unique', 'targetAttribute' => ['rec_id', 'opt_id'], 'message' => 'The combination of Rec ID and Opt ID has already been taken.'],
            [['rec_id'], 'exist', 'skipOnError' => true, 'targetClass' => Recursos::className(), 'targetAttribute' => ['rec_id' => 'id']],
            [['opt_id'], 'exist', 'skipOnError' => true, 'targetClass' => RecursosOptions::className(), 'targetAttribute' => ['opt_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rec_id' => 'Rec ID',
            'opt_id' => 'Opt ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRec()
    {
        return $this->hasOne(Recursos::className(), ['id' => 'rec_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpt()
    {
        return $this->hasOne(RecursosOptions::className(), ['id' => 'opt_id']);
    }
}
