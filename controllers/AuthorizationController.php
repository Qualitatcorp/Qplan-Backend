<?php 

namespace app\controllers;

use yii;

// use yii\web\Response;
use app\components\Authorization;
use app\models\user\Resource;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;

class AuthorizationController extends Controller
{
	public function behaviors()
	{
		return \yii\helpers\ArrayHelper::merge(parent::behaviors(),[
			'authenticator'=>[
	    		'class' => HttpBearerAuth::className()  
	    	],
	    	'authorization'=>[
            	'class' => Authorization::className(),
	    	],
	    	'verbs'=>[           
		    	'class' => \yii\filters\VerbFilter::className(),
	            'actions' => [
	                // 'index'  => ['get'],
	                // 'view'   => ['get'],
	                // 'create' => ['get', 'post'],
	                // 'update' => ['get', 'put', 'post'],
	                // 'delete' => ['post', 'delete'],
	                'identity' => ['get'],
	                'resources' => ['get'],
	                'permission' => ['get'],
	            ],
	    	],
	    	// 'bootstrap'=>[
	     //        'class' => 'yii\filters\ContentNegotiator',
	     //        'formats' => [
	     //            'application/json' => Response::FORMAT_JSON,
	     //            'application/xml' => Response::FORMAT_XML,
	     //        ],
	     //        'languages' => [
	     //            'es',
	     //            'en',
	     //        ],
	    	// ]
		]);
	}

	public function actionPermission()
	{
		// $resource=Yii::$app->user->identity->getResources()->with('children')->asArray()->All();
		$resource=Yii::$app->user->identity->getResources()->with('children')->asArray()->All();
		return $resource;
	}
	public function actionIdentity()
	{
		return [Yii::$app->user->identity];
	}

	public function actionResources($id=null)
	{
		if(empty($id)){
		return Resource::find()->with('children.children')->asArray()->All();
		}else{
			return Resource::find()->where(['resource'=>$id])->with('children')->asArray()->All();
		}

		// $resource=Yii::$app->user->identity->getResources()->with('children.children')->asArray()->All();
		// $resource=Yii::$app->user->identity->getResources()->/*select(['resource'])->*/with('children')->asArray()->All();
		// $resource=Yii::$app->user->identity->resources
		// $resources[]=
		return $resource;
	}	
}