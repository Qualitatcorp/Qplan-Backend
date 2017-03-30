<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "perfil_modulo".
 *
 * @property string $id
 * @property string $per_id
 * @property string $nombre
 * @property string $nivel
 * @property string $evaluacion
 * @property double $ponderacion
 *
 * @property FichaPractica[] $fichaPracticas
 * @property Ficha[] $fics
 * @property PerfilEvaluacionTeorica[] $perfilEvaluacionTeoricas
 * @property EvaluacionTeorica[] $evts
 * @property Perfil $per
 */
class PerfilModulo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'perfil_modulo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['per_id', 'nombre', 'evaluacion'], 'required'],
            [['per_id'], 'integer'],
            [['nivel', 'evaluacion'], 'string'],
            [['ponderacion'], 'number'],
            [['nombre'], 'string', 'max' => 256],
            [['per_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perfil::className(), 'targetAttribute' => ['per_id' => 'id']],
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
            'nombre' => 'Nombre',
            'nivel' => 'Nivel',
            'evaluacion' => 'Evaluacion',
            'ponderacion' => 'Ponderacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFichaPracticas()
    {
        return $this->hasMany(FichaPractica::className(), ['mod_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFics()
    {
        return $this->hasMany(Ficha::className(), ['id' => 'fic_id'])->viaTable('ficha_practica', ['mod_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerfilEvaluacionTeoricas()
    {
        return $this->hasMany(PerfilEvaluacionTeorica::className(), ['mop_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvts()
    {
        return $this->hasMany(EvaluacionTeorica::className(), ['id' => 'evt_id'])->viaTable('perfil_evaluacion_teorica', ['mop_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPer()
    {
        return $this->hasOne(Perfil::className(), ['id' => 'per_id']);
    }
}
