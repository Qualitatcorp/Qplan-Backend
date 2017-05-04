<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property string $id
 * @property string $username
 * @property string $rut
 * @property string $mail
 * @property string $password
 * @property string $nombre
 * @property string $paterno
 * @property string $materno
 * @property string $cargo
 * @property string $nacimiento
 *
 * @property EmpresaUser[] $empresaUsers
 * @property Empresa[] $emps
 * @property UserAuthentication[] $userAuthentications
 * @property UserAuthorization[] $userAuthorizations
 * @property UserResource[] $res
 */
class User extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'user';
    }


    public function rules()
    {
        return [
            [['username', 'password', 'nombre'], 'required'],
            [['nacimiento'], 'safe'],
            [['username'], 'string', 'max' => 20],
            [['rut'], 'string', 'max' => 12],
            [['mail', 'nombre', 'cargo'], 'string', 'max' => 128],
            [['password'], 'string', 'max' => 40],
            [['paterno', 'materno'], 'string', 'max' => 64],
            [['username'], 'unique'],
            [['mail'], 'unique'],
            [['rut'], 'unique'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'rut' => 'Rut',
            'mail' => 'Mail',
            'password' => 'Password',
            'nombre' => 'Nombre',
            'paterno' => 'Paterno',
            'materno' => 'Materno',
            'cargo' => 'Cargo',
            'nacimiento' => 'Nacimiento',
        ];
    }

    public function getEmpresaUsers()
    {
        return $this->hasMany(EmpresaUser::className(), ['usu_id' => 'id']);
    }

    public function getEmps()
    {
        return $this->hasMany(Empresa::className(), ['id' => 'emp_id'])->viaTable('empresa_user', ['usu_id' => 'id']);
    }

    public function getUserAuthentications()
    {
        return $this->hasMany(UserAuthentication::className(), ['user_id' => 'id']);
    }

    public function getUserAuthorizations()
    {
        return $this->hasMany(UserAuthorization::className(), ['user_id' => 'id']);
    }

    public function getRes()
    {
        return $this->hasMany(UserResource::className(), ['id' => 'res_id'])->viaTable('user_authorization', ['user_id' => 'id']);
    }
}
