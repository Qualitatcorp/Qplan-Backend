<?php 

namespace app\controllers;

use yii;
use app\models\user\User;
use yii\rest\Controller;

class AuthenticationController extends Controller
{

	// public function actionIndex()
	// {
	// 	return User::find(['id'=>1])->One();
	// }
	public function actionToken()
	{
		return User::TokenByCredentials();
	}

	public function actionRefresh()
	{
		return User::RefreshToken();
	}

}