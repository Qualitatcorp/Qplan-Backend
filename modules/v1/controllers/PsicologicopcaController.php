<?php 

namespace app\modules\v1\controllers;
use yii;
use yii\rest\Controller;
use soapClient;
use app\modules\v1\models\FichaTercero;

class PsicologicopcaController extends Controller
{


  public $url = 'https://timshr.com/services/PcaService.svc?singleWsdl' ;    
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
   $model=new FichaTercero; 
   $client = new SoapClient( $this->url);
   $request = Yii::$app->request;
   $trabajador = $request->post();
   if($trabajador['sexo'] == "FEMENINO"){
     $sexo = 70;
   }else{
     $sexo = 77; 
   }
   
   $response =   $client->AddSurvey(
     array('evaluacionPca' => array(
      "CoCod" => "5ccf4857-2691-4eaf-b2e0-f7d42375691c",
      "CoMailNot"=>"",
      "CoRegCod"=>"es-cl",
      "PcaTip"=>"D",
      "PerGen"=> $sexo,
      "PerMail"=>$trabajador['mail'],
      "PerNom"=> $trabajador['nombre'],
      "PerNumIde"=>$trabajador['rut'],
      "PerPriApe"=>$trabajador['paterno'],
      "PerSegApe"=>$trabajador['materno'],
      ) )
     );
    
    if($response->AddSurveyResult->_x003C_Ok_x003E_k__BackingField){
      $model->fic_id  = $trabajador['ficha'];
      $model->mod_id  = '1';
      $model->prov_id = '1';
      $model->nota = '1';
      $model->identity =$response->AddSurveyResult->_x003C_PcaCod_x003E_k__BackingField;    
      $model->save();
    } 
    return $response;
   


 }
  public function actionGotosurvey()
  { 
    $req = Yii::$app->request;
    $survey =$req->post();
    $client = new SoapClient( $this->url);
    $response =  $client->GoToSurvey(
      array(
      'codigoPca' => $survey['codpca'],
      'repCod'=>'5ccf4857-2691-4eaf-b2e0-f7d42375691c' 
      ) 
    );
   return $response;

  }
  public function actionGetresult(){
    $req = Yii::$app->request;
    $survey =$req->post();
    $client = new SoapClient( $this->url);
    $response =  $client->GetResult (
      array(
      'codigoPca' => $survey['codpca'],
      // 'codigoPca' =>  'e129fe4a-8bcb-4f26-9588-abaa34dde49e',
      'repCod'=>'5ccf4857-2691-4eaf-b2e0-f7d42375691c' 
      ) 
    );
   return $response;
   
   
  }



}

