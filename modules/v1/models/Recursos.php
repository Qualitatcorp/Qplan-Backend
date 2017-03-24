<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "recursos".
 *
 * @property string $id
 * @property string $pre_id
 * @property string $tipo
 *
 * @property EvaluacionPregunta $pre
 * @property RecursosHasOptions[] $recursosHasOptions
 * @property RecursosOptions[] $opts
 * @property RecursosHasSources[] $recursosHasSources
 * @property RecursosSources[] $srcs
 */
class Recursos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recursos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pre_id', 'tipo'], 'required'],
            [['pre_id'], 'integer'],
            [['tipo'], 'string'],
            [['pre_id'], 'unique'],
            [['pre_id'], 'exist', 'skipOnError' => true, 'targetClass' => EvaluacionPregunta::className(), 'targetAttribute' => ['pre_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pre_id' => 'Pre ID',
            'tipo' => 'Tipo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPre()
    {
        return $this->hasOne(EvaluacionPregunta::className(), ['id' => 'pre_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecursosHasOptions()
    {
        return $this->hasMany(RecursosHasOptions::className(), ['rec_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpts()
    {
        return $this->hasMany(RecursosOptions::className(), ['id' => 'opt_id'])->viaTable('recursos_has_options', ['rec_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecursosHasSources()
    {
        return $this->hasMany(RecursosHasSources::className(), ['rec_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSrcs()
    {
        return $this->hasMany(RecursosSources::className(), ['id' => 'src_id'])->viaTable('recursos_has_sources', ['rec_id' => 'id']);
    }
}
