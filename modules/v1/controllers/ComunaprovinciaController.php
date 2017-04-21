<?php 

namespace app\modules\v1\controllers;

use yii\rest\ActiveController;

class ComunaprovinciaController extends ActiveController
{
	public $modelClass = 'app\modules\v1\models\ComunaProvincia';

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

	public function actionSearch()
	{
		if (!empty($_GET)) {
			$model = new $this->modelClass;
			foreach ($_GET as $key => $value) {
				if (!$model->hasAttribute($key)) {
					throw new \yii\web\HttpException(404, 'Atributo invalido :' . $key);
				}
			}
			try {
			   $query = $model->find();
				foreach ($_GET as $key => $value) {
					if ($key != 'age') {
						$query->andWhere(['like', $key, $value]);
					}
					if ($key == 'age') {
						$agevalue = explode('-',$value);
						$query->andWhere(['between', $key,$agevalue[0],$agevalue[1]]);
					}
				}

				$provider = new \yii\data\ActiveDataProvider([
					'query' => $query,
					'sort' => [
						'defaultOrder' => [
							'id'=> SORT_DESC
						]
					],
				  	'pagination' => [
						'defaultPageSize' => 20,
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