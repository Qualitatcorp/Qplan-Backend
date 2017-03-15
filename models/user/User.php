<?php

namespace app\models\user;

use Yii;

use app\models\user\Authentication;
use app\models\user\Client;

use yii\web\HttpException;

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
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
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }
    public static function findUsername($username)
    {
        return static::findOne(['username'=>$username]);
    }
    public static function findEmail($mail)
    {
        return static::findOne(['mail'=>$mail]);
    }
    public static function findRut($rut)
    {
        return static::findOne(['rut'=>$rut]);
    }

    public static function findMultipleMethod($value)
    {
        $user=static::findUsername($value);
        if(!empty($user))
            return $user;
        else{
            $user=static::findEmail($value);
            if($user)
                return $user;
            else
                return static::findRut($value);
        }
    }
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $Auth=Authentication::findAccessToken($token);
        if(!empty($Auth)){
            return $Auth->user;
        }
        return null;
    }
    public static function TokenByCredentials($timeOut=null,$refresh=false)
    {
        //Request
        $request = Yii::$app->request;
        //Credentials
        $auth=[
            'username'=>$request->post('username'),
            'password'=>$request->post('password'),
            'grant_type'=>$request->post('grant_type'),
            'client_id'=>$request->post('client_id'),
            'client_secret'=>$request->post('client_secret'),
            'refresh'=>$request->post('refresh')
        ];
        // Validar Usuarios por username rut email
        $user=static::findMultipleMethod($auth['username']);
        switch ($auth['grant_type']) {
            case 'password':
                if(empty($user)){
                    throw new HttpException(401, "Error en credenciales. Usuario no existe.");
                }else{
                    if(!$user->validatePassword($auth['password'])){
                        throw new HttpException(401, "Error en credenciales. Contraseña invalida");
                    }
                }
                break;
            default:
                throw new HttpException(405, "Error metodo inexistente.");
                break;
        }
        //Valida Cliente
        $cliente=Client::findByName($auth['client_id']);
        if(empty($cliente)){
            throw new HttpException(401, "Error en credenciales. Cliente no existe.");
        }else{
            if(!$cliente->validateSecret($auth['client_secret'])){
                throw new HttpException(401, "Error en credenciales. Secreto invalido.");
            }
        }
        //si no existe un timeOut se asigna uno por defecto
        if(empty($timeOut)){
            $timeOut=3600;
        }

        if(!empty($auth['refresh'])){
            $refresh=($auth['refresh']==='true');
        }
        $token = Authentication::GrantAccess($user->primaryKey,$cliente->primaryKey,$timeOut,$refresh);

        $access_token=[
            'access_token'=>$token->primaryKey,
            'token_type'=>'Bearer',
            'expire_in'=>$timeOut,
            // 'scope'=>$user
        ];
        if(!empty($token->refresh)){
            $access_token['refresh']=$token->refresh;
        }
        return $access_token;
        //Valida IP
        // $auth['User Host']=Yii::$app->request->userHost;
        // $auth['User IP']=Yii::$app->request->userIP;
        // return $auth;

        // $userHost = Yii::$app->request->userHost;
        // $userIP = Yii::$app->request->userIP;
    }
    public static function RefreshToken()
    {
        //Request
        $request = Yii::$app->request;
        //Credentials
        $access=[
            'token'=>$request->post('access_token'),
            'refresh'=>$request->post('refresh')
        ];
        $auth=Authentication::findAccessToken($access{'token'});
        if(empty($auth)){
            throw new HttpException(401, "No existen estas credenciales.");
        }
        if($auth->refresh($access['refresh'])){
            return [
                'refresh'=>$auth->refresh,
                'expire'=>3600
            ];
        }else{
            throw new HttpException(401, "Error de autorización.");
        }

        return $auth;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getAuthKey()
    {
        return $this->authKey;
    }
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    // Relacion
    public function getEmpresaUsers()
    {
        return $this->hasMany(EmpresaUser::className(), ['usu_id' => 'id']);
    }

    public function getEmpresas()
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

    public function getResources()
    {
        return $this->hasMany(Resource::className(), ['id' => 'res_id'])->viaTable('user_authorization', ['user_id' => 'id']);
    }
}
