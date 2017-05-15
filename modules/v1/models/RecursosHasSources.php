<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "recursos_has_sources".
 *
 * @property string $id
 * @property string $rec_id
 * @property string $src_id
 *
 * @property Recursos $rec
 * @property RecursosSources $src
 */
class RecursosHasSources extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'recursos_has_sources';
    }


    public function rules()
    {
        return [
            [['rec_id', 'src_id'], 'required'],
            [['rec_id', 'src_id'], 'integer'],
            [['rec_id', 'src_id'], 'unique', 'targetAttribute' => ['rec_id', 'src_id'], 'message' => 'The combination of Rec ID and Src ID has already been taken.'],
            [['rec_id'], 'exist', 'skipOnError' => true, 'targetClass' => Recursos::className(), 'targetAttribute' => ['rec_id' => 'id']],
            [['src_id'], 'exist', 'skipOnError' => true, 'targetClass' => RecursosSources::className(), 'targetAttribute' => ['src_id' => 'id']],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rec_id' => 'Rec ID',
            'src_id' => 'Src ID',
        ];
    }

    public function getRec()
    {
        return $this->hasOne(Recursos::className(), ['id' => 'rec_id']);
    }

    public function getSrc()
    {
        return $this->hasOne(RecursosSources::className(), ['id' => 'src_id']);
    }
}
