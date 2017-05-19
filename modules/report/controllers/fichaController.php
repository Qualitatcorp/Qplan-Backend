<?php

namespace app\modules\report\controllers;
use app\modules\v1\models\OrdenTrabajo;
use app\modules\v1\models\Ficha;
use yii\web\Controller;

/**
 * Default controller for the `report` module
 */
class FichaController extends Controller
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
   
    public function actionPractica($id)
    {
        // style='padding-left:44%'
        $footer = " <div> <p style='width:100px; text-aling:center; margin:0 auto;'>Página {PAGENO}  de {nb} </p></div>";
        //consulta
        $ficha = Ficha::findOne($id);
        // verifica si existe
        if($ficha){
            $style=file_get_contents('http://127.0.0.1/mpdf-bootstrap.min.css');
            $report = $this->renderPartial('_practica',array('ficha'=>$ficha),true);
            $header = $this->renderPartial('_headerpractica',array('ficha'=>$ficha),true);
            $mpdf = new \Mpdf\Mpdf();
         
            $mpdf->SetTitle('Evaluacion Practica');
            $mpdf->SetAuthor('Qualitat');
            $mpdf->SetHTMLHeader($header);
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
