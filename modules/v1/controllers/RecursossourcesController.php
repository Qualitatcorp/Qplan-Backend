<?php 

namespace app\modules\v1\controllers;

use yii\rest\ActiveController;
use yii;
use yii\web\UploadedFile;
class RecursossourcesController extends ActiveController
{
	public $modelClass = 'app\modules\v1\models\RecursosSources';

public function actions()
{
    $actions = parent::actions();

    // disable the "delete" and "create" actions
    unset($actions['create'],$actions['index']);

     
    return $actions;
}

	public function behaviors()
	{
		return \yii\helpers\ArrayHelper::merge(parent::behaviors(),[
			'authenticator'=>[
				'class' => \yii\filters\auth\HttpBearerAuth::className()  
			],
			'authorization'=>[
				'class' => \app\components\Authorization::className(),
			],
		]);
	}
	 
 
	public function actionCreate()
	{	
		if (Yii::$app->request->isPost) {
			$request=\Yii::$app->request;
			$model = new $this->modelClass;
			$model->attributes=Yii::$app->request->post();
			$model->file = UploadedFile::getInstancesByName('file');
			$model->attributes=$request;
			$model->file = UploadedFile::getInstancesByName('file');
			if ($model->file == null){
				throw new \yii\web\HttpException(500, 'Error interno del sistema.');
			} 


			if ($model->upload()){

				return array('status'=>1,'data'=>array_filter($model->attributes));
			}else{
				throw new \yii\web\HttpException(500, 'Error interno del sistema.');
			}

		}



	}



	 
	
	public function actionSearch()
	{
		if (!empty($_GET)) {
			$request=\Yii::$app->request;
			$reserve=['page','index','order','limit'];
			$model = new $this->modelClass;
			foreach ($_GET as $key => $value) {
				if (!$model->hasAttribute($key)&&!in_array($key,$reserve)) {
					throw new \yii\web\HttpException(404, 'Atributo invalido :' . $key);
				}
			}
			try {
			   	$query = $model->find();
			   	$range=['id'];
				foreach ($_GET as $key => $value) {
					if(!in_array($key,$reserve)){
						if (in_array($key,$range)) {
							$limit = explode('-',$value);
							$query->andWhere(['between', $key,$limit[0],$limit[1]]);
						}else{
							$query->andWhere(['like', $key, $value]);
						}
					}
				}
				$id=($request->get('index'))?$request->get('index'):'id';
				$sort=($request->get('order')=='asc')?SORT_ASC:SORT_DESC;
				$provider = new \yii\data\ActiveDataProvider([
					'query' => $query,
					'sort' => [
						'defaultOrder' => [
							$id=>$sort
						]
					],
				  	'pagination' => [
						'defaultPageSize' => 20,'page'=>(isset($_GET['page']))?intval($_GET['page'])-1:0
					],
				]);
			} catch (Exception $ex) {
				throw new \yii\web\HttpException(500, 'Error interno del sistema.');
			}

			if ($provider->getCount() <= 0) {
				throw new \yii\web\HttpException(404, 'No existen entradas con los parametros propuestos.');
			} else {
				return $provider;
			}
		} else {
			throw new \yii\web\HttpException(400, 'No se puede crear una query a partir de la informacion propuesta.');
		}
	}
}