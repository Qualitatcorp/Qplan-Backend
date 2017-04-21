<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "clasificacion_perfil".
 *
 * @property string $id
 * @property integer $cla_id
 * @property string $per_id
 * @property string $acierto
 *
 * @property Clasificacion $cla
 * @property Perfil $per
 */
class ClasificacionPerfil extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clasificacion_perfil';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cla_id', 'per_id', 'acierto'], 'required'],
            [['cla_id', 'per_id'], 'integer'],
            [['acierto'], 'number'],
            [['cla_id', 'per_id'], 'unique', 'targetAttribute' => ['cla_id', 'per_id'], 'message' => 'The combination of Cla ID and Per ID has already been taken.'],
            [['cla_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clasificacion::className(), 'targetAttribute' => ['cla_id' => 'id']],
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
            'cla_id' => 'Cla ID',
            'per_id' => 'Per ID',
            'acierto' => 'Acierto',
        ];
    }

    public function extraFields()
    {
        return ['clasificacion','perfil'];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClasificacion()
    {
        return $this->hasOne(Clasificacion::className(), ['id' => 'cla_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerfil()
    {
        return $this->hasOne(Perfil::className(), ['id' => 'per_id']);
    }
}
