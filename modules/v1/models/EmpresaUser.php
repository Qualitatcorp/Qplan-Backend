<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "empresa_user".
 *
 * @property integer $emu_id
 * @property integer $emp_id
 * @property string $usu_id
 *
 * @property Empresa $emp
 * @property User $usu
 */
class EmpresaUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'empresa_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emp_id', 'usu_id'], 'required'],
            [['emp_id', 'usu_id'], 'integer'],
            [['emp_id', 'usu_id'], 'unique', 'targetAttribute' => ['emp_id', 'usu_id'], 'message' => 'The combination of Emp ID and Usu ID has already been taken.'],
            [['emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::className(), 'targetAttribute' => ['emp_id' => 'id']],
            [['usu_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['usu_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'emu_id' => 'Emu ID',
            'emp_id' => 'Emp ID',
            'usu_id' => 'Usu ID',
        ];
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
    public function getUsu()
    {
        return $this->hasOne(User::className(), ['id' => 'usu_id']);
    }
}
