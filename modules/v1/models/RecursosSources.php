<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "recursos_sources".
 *
 * @property string $id
 * @property string $src
 * @property string $type
 * @property string $title
 *
 * @property RecursosHasSources[] $recursosHasSources
 * @property Recursos[] $recs
 */
class RecursosSources extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recursos_sources';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['src', 'type'], 'required'],
            [['type'], 'string'],
            [['src'], 'string', 'max' => 128],
            [['title'], 'string', 'max' => 256],
            [['src'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'src' => 'Src',
            'type' => 'Type',
            'title' => 'Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecursosHasSources()
    {
        return $this->hasMany(RecursosHasSources::className(), ['src_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecs()
    {
        return $this->hasMany(Recursos::className(), ['id' => 'rec_id'])->viaTable('recursos_has_sources', ['src_id' => 'id']);
    }
}