<?php 

namespace app\components;

use Yii;
use yii\base\Action;
use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;

/**
* Access
*/
class Authorization extends ActionFilter
{
		public function beforeAction($action)
		{
				if(static::CheckAccess()){
					return true;
				}else{
					$this->denyAccess();
				}
				return false;
		}
		public static function CheckAccess($user_id=null,$resource=null)
		{
			if(empty($resource)){
				if(empty($user_id)){
					$user_id=Yii::$app->user->id;
					if(!empty(Yii::$app->controller->module->id))
						$resource[]=Yii::$app->controller->module->id;
					$resource[]=Yii::$app->controller->id;
					$resource[]=Yii::$app->controller->action->id;
				}else{
					$resource=$user_id;
					$user_id=Yii::$app->user->identity->getId();
				}
			}

			//auto Registrar Accesos
			static::registerResource($resource);
			// permitir siempre
			// return true;
			return Yii::$app->db->createCommand("CALL sp_access_resource_user(:user_id, :resource)")
							->bindValue(':user_id' , $user_id)
							->bindValue(':resource',static::SerializeResource($resource))
							->queryOne()['PERMISSION']==='ALLOW';
		}

		public static function SerializeResource($resource)
		{
			return (is_array($resource))?implode("_", $resource):$resource;
		}

		public static function registerResource($resource)
		{
			$new_resource=static::SerializeResource($resource);
			Yii::$app->db->createCommand("CALL sp_resource_register(:new_resource);")->bindValue(':new_resource',$new_resource)->execute();
			Yii::$app->db->createCommand("CALL sp_access_permission('RESOURCE',:new_resource,'ALLOW');")->bindValue(':new_resource',$new_resource)->execute();
		}
		public static function assingResource($identity,$resource,$type='user')
		{
			if($type==='user'){
				Yii::$app->db->createCommand("CALL sp_access_grant_user_resource(:new_resource)")
					->bindValue(':new_resource',static::SerializeResource($resource))
					->bindValue(':new_resource',static::SerializeResource($resource))
					->execute();
			}else{
				Yii::$app->db->createCommand("CALL sp_access_grant_role_resource(:new_resource)")
					->bindValue(':new_resource',static::SerializeResource($resource))
					->bindValue(':new_resource',static::SerializeResource($resource))
					->execute();
			}
		}    
		public static function unsingResource($identity,$resource,$type='user')
		{
			if($type==='user'){
				Yii::$app->db->createCommand("CALL sp_access_revoke_user_resource(:new_resource)")
								->bindValue(':new_resource',static::SerializeResource($resource))
								->bindValue(':new_resource',static::SerializeResource($resource))
								->execute();
			}else{
				Yii::$app->db->createCommand("CALL sp_access_revoke_role_resource(:new_resource)")
								->bindValue(':new_resource',static::SerializeResource($resource))
								->bindValue(':new_resource',static::SerializeResource($resource))
								->execute();
			}
		}
		public static function registerRole($resource)
		{
			Yii::$app->db->createCommand("CALL sp_access_register_role(:new_resource)")
							->bindValue(':new_resource',static::SerializeResource($resource))
							->execute();
		}
		public static function removeRole($resource)
		{
			Yii::$app->db->createCommand("CALL sp_access_remove_role(:new_resource)")
							->bindValue(':new_resource',static::SerializeResource($resource))
							->execute();
		}
		public static function assignRole($user_id,$resource)
		{
			Yii::$app->db->createCommand("CALL sp_access_register_user_role(:new_resource)")
							->bindValue(':new_resource',static::SerializeResource($resource))
							->bindValue(':new_resource',static::SerializeResource($resource))
							->execute();
		}
		public static function unsingRole($user_id,$resource)
		{
			Yii::$app->db->createCommand("CALL sp_access_remove_user_role(:new_resource)")
							->bindValue(':new_resource',static::SerializeResource($resource))
							->bindValue(':new_resource',static::SerializeResource($resource))
							->execute();
		}
		protected function denyAccess()
		{
				throw new ForbiddenHttpException(Yii::t('yii', 'No tienes acceso a este recurso'));
		}

		public static function actionHolaMundo()
		{
			 var_dump("holamundo");
			 die();
		}

}