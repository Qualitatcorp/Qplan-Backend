<?php

namespace app\modules\report\controllers;
use app\modules\v1\models\OrdenTrabajo;
use yii\web\Controller;

/**
 * Default controller for the `report` module
 */
class OtController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    // public function behaviors()
    // {
    //     return \yii\helpers\ArrayHelper::merge(parent::behaviors(),[
    //         'authenticator'=>[
    //             'class' => \yii\filters\auth\HttpBearerAuth::className()  
    //         ],
    //         'authorization'=>[
    //             'class' => \app\components\Authorization::className(),
    //         ],
    //     ]);
    // }
   
    public function actionIndex($id_ot)
    {
       // style='padding-left:44%'
          $footer = " <div> <p style='width:100px; text-aling:center; margin:0 auto;'>Página {PAGENO}  de {nb} </p></div>";



        $ot = OrdenTrabajo::findOne($id_ot);
        if($ot){
            
            $style=file_get_contents('http://127.0.0.1/mpdf-bootstrap.min.css');
            //  $this->renderPartial('_report',array('ot'=>$ot  ),false );
            $report =$this->renderPartial('_report',array('ot'=>$ot  ),true);
            
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->SetTitle('Orden de Trabajo Nº'. $ot->id);
            $mpdf->SetAuthor('Qualitat');
            $mpdf->WriteHTML($style,1);
            $mpdf->WriteHTML($report ,2);
            $mpdf->SetHTMLFooter($footer);
           
            $mpdf->Output();
        }else{
           throw new \yii\web\NotFoundHttpException();
           
        }
       
    }
    private function pre($s){
       echo "<pre>";
       print_r($s);
       echo "</pre>";
    }
    
}
