<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "recursos_options".
 *
 * @property string $id
 * @property string $variable
 * @property string $valor
 * @property string $tipo
 *
 * @property RecursosHasOptions[] $recursosHasOptions
 * @property Recursos[] $recs
 */
class RecursosOptions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recursos_options';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['variable', 'valor'], 'required'],
            [['tipo'], 'string'],
            [['variable'], 'string', 'max' => 128],
            [['valor'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'variable' => 'Variable',
            'valor' => 'Valor',
            'tipo' => 'Tipo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecursosHasOptions()
    {
        return $this->hasMany(RecursosHasOptions::className(), ['opt_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecs()
    {
        return $this->hasMany(Recursos::className(), ['id' => 'rec_id'])->viaTable('recursos_has_options', ['opt_id' => 'id']);
    }
}
