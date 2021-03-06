<?php

namespace app\modules\report\controllers;
use yii\web\Controller;
use app\modules\v1\models\OrdenTrabajo;

class OtController extends Controller
{
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
   
    public function actionListado($id)
    {
       // style='padding-left:44%'
        $footer = " <div> <p style='width:100px; text-aling:center; margin:0 auto;'>Página {PAGENO}  de {nb} </p></div>"; 
        $ot = OrdenTrabajo::findOne($id);
        if($ot){
            $style=file_get_contents(\Yii::getAlias('@webroot').DIRECTORY_SEPARATOR.'css/mpdf-bootstrap.min.css');
            //  $this->renderPartial('_report',array('ot'=>$ot  ),false );
            $report =$this->renderPartial('listado/_report',array('ot'=>$ot  ),true);
            $mpdf = new \Mpdf\Mpdf(array(
                'mode' => '',
                'format' => 'Letter',
                'default_font_size' => 0,
                'default_font' => '10',
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
    public function actionDetalle($id)
    {
         // style='padding-left:44%'
        $footer = " <div> <p style='font-size: 9;width:140px; text-aling:center; margin:0 auto;'>OT Nº {$id}  - Página {PAGENO}  de {nb}</p></div>";
        $ot = OrdenTrabajo::findOne($id);
        if($ot){

            $style=file_get_contents(\Yii::getAlias('@webroot').DIRECTORY_SEPARATOR.'css/mpdf-bootstrap.min.css');
                    //  $this->renderPartial('_report',array('ot'=>$ot  ),false );
            $head  = $this->renderPartial('detalle/_head',array('ot'=>$ot  ));
            $lista = $this->renderPartial('detalle/_listado',array('ot'=>$ot  ) );
            $info_tecnico = $this->renderPartial('detalle/_informeTecnico' ,array('ot'=>$ot  ));
            $mpdf  = new \Mpdf\Mpdf(array(
                'mode' => '',
                'format' => 'Letter',
                'default_font_size' => 0,
                'default_font' => '10',
                'margin_left' => 15,
                'margin_right' => 10,
                'margin_top' => 10,
                'margin_bottom' => 15,
                'margin_header' => 20,
                'margin_footer' => 5,
                'orientation' => 'L'));
            $mpdf->SetHTMLFooter($footer);
            $mpdf->AddPage('L');
            $mpdf->SetTitle('Orden de Trabajo Nº'. $ot->id);
            $mpdf->SetAuthor('Qualitat');
            $mpdf->WriteHTML($style,1);
            // $mpdf->WriteHTML($head ,2);           
            $mpdf->WriteHTML($lista ,2);
            $mpdf->AddPage('');
            $mpdf->WriteHTML($info_tecnico ,2);

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
