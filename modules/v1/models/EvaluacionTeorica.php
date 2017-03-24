<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "evaluacion_teorica".
 *
 * @property string $id
 * @property integer $tev_id
 * @property string $nombre
 * @property string $descripcion
 *
 * @property EvaluacionItem[] $evaluacionItems
 * @property EvaluacionTipo $tev
 * @property PerfilEvaluacionTeorica[] $perfilEvaluacionTeoricas
 * @property PerfilModulo[] $mops
 */
class EvaluacionTeorica extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'evaluacion_teorica';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tev_id', 'nombre'], 'required'],
            [['tev_id'], 'integer'],
            [['descripcion'], 'string'],
            [['nombre'], 'string', 'max' => 256],
            [['tev_id'], 'exist', 'skipOnError' => true, 'targetClass' => EvaluacionTipo::className(), 'targetAttribute' => ['tev_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tev_id' => 'Tev ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvaluacionItems()
    {
        return $this->hasMany(EvaluacionItem::className(), ['evt_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTev()
    {
        return $this->hasOne(EvaluacionTipo::className(), ['id' => 'tev_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerfilEvaluacionTeoricas()
    {
        return $this->hasMany(PerfilEvaluacionTeorica::className(), ['evt_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMops()
    {
        return $this->hasMany(PerfilModulo::className(), ['id' => 'mop_id'])->viaTable('perfil_evaluacion_teorica', ['evt_id' => 'id']);
    }
}
