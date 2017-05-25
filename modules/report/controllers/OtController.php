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
   
    public function actionListado($id)
    {
       // style='padding-left:44%'
       $footer = " <div> <p style='width:100px; text-aling:center; margin:0 auto;'>Página {PAGENO}  de {nb} </p></div>";



        $ot = OrdenTrabajo::findOne($id);
        if($ot){
            
            $style=file_get_contents('http://127.0.0.1/mpdf-bootstrap.min.css');
            //  $this->renderPartial('_report',array('ot'=>$ot  ),false );
            $report =$this->renderPartial('listado/_report',array('ot'=>$ot  ),true);
            $mpdf = new \Mpdf\Mpdf(array(
                'mode' => '',
                'format' => 'Letter',
                'default_font_size' => 0,
                'default_font' => '',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 10,
                'margin_bottom' => 30,
                'margin_header' => 20,
                'margin_footer' => 9,
                'orientation' => 'l'));
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
