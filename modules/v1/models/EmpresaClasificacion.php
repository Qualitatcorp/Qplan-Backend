<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "empresa_clasificacion".
 *
 * @property string $id
 * @property integer $cla_id
 * @property integer $emp_id
 * @property string $per_id
 * @property string $acierto
 *
 * @property Clasificacion $cla
 * @property Empresa $emp
 * @property Perfil $per
 */
class EmpresaClasificacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'empresa_clasificacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cla_id', 'emp_id', 'per_id', 'acierto'], 'required'],
            [['cla_id', 'emp_id', 'per_id'], 'integer'],
            [['acierto'], 'number'],
            [['cla_id', 'emp_id', 'per_id'], 'unique', 'targetAttribute' => ['cla_id', 'emp_id', 'per_id'], 'message' => 'The combination of Cla ID, Emp ID and Per ID has already been taken.'],
            [['cla_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clasificacion::className(), 'targetAttribute' => ['cla_id' => 'id']],
            [['emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::className(), 'targetAttribute' => ['emp_id' => 'id']],
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
            'emp_id' => 'Emp ID',
            'per_id' => 'Per ID',
            'acierto' => 'Acierto',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCla()
    {
        return $this->hasOne(Clasificacion::className(), ['id' => 'cla_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmp()
    {
        return $this->hasOne(Empresa::className(), ['id' => 'emp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPer()
    {
        return $this->hasOne(Perfil::className(), ['id' => 'per_id']);
    }
}
