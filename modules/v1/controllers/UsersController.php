<?php 

namespace app\modules\v1\controllers;

use yii;
use app\models\user\Authorization;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;

class UsersController extends ActiveController
{
    public $modelClass = 'app\models\user\User';

	public function behaviors()
	{
	    $behaviors = parent::behaviors();
	    $behaviors['authenticator'] = [
	    	'class' => HttpBearerAuth::className()  
	    ];
	    $behaviors['authorization'] = [
            'class' => Authorization::className(),
        ];
	    return $behaviors;
	}
// public function beforeAction($action)
// {
//     if (!parent::beforeAction($action))return false;
//     var_dump($this->action->id,$this->id);
//     die();
//     return true;
// }


	public function actionIdentity()
	{
		return [Yii::$app->user->identity];
		// 		return [
		// 	"hola"=>[
		// 		["hola"=>"Hola"]
		// 	]
		// ];
	}
}