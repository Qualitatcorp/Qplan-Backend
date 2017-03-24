<?php 

// Informacion de busqueda para api rest

	public function actionSearch()
	{
		if (!empty($_GET)) {
			$model = new $this->modelClass;
			foreach ($_GET as $key => $value) {
				if (!$model->hasAttribute($key)) {
					throw new \yii\web\HttpException(404, 'Invalid attribute:' . $key);
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
				throw new \yii\web\HttpException(500, 'Internal server error');
			}

			if ($provider->getCount() <= 0) {
				throw new \yii\web\HttpException(404, 'No entries found with this query string');
			} else {
				return $provider;
			}
		} else {
			throw new \yii\web\HttpException(400, 'There are no query string');
		}
	}

// Para la authentication del sistema  y verbose de los recursos

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
		]);
	}