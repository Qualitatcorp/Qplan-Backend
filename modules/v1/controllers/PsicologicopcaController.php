<?php 

namespace app\modules\v1\controllers;
use yii;
use yii\rest\Controller;
use soapClient;
class PsicologicopcaController extends Controller
{



  public function actionCreate()
  { 
   $request = Yii::$app->request;
   $trabajador = $request->post();
   if($trabajador['sexo'] == "FEMENINO"){
     $sexo = 70;
   }else{
     $sexo = 77; 
   }
   $client =
   new SoapClient(
    'https://timshr.com/services/PcaService.svc?singleWsdl'
    );
   $response =  $client->AddSurvey(
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
   return $response;

 }
 

}

