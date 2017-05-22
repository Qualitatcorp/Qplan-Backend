<?php

namespace app\modules\report\controllers;
use app\modules\v1\models\Ficha;
use yii\web\Controller;
class InformeController extends Controller
{
 
   
    public function actionPractica($id)
    {
         
      
        $informe = Ficha::findOne($id);
         
        if($informe){
            $num_page = " <div> <p style='width:100px; text-aling:center; margin:0 auto;'>Página {PAGENO} de {nb} </p></div>";
            $style=file_get_contents('http://127.0.0.1/mpdf-bootstrap.min.css');
            $header = $this->renderPartial('_header');
          

            $body = $this->renderPartial('_body',array('informe'=>$informe),true);

            $mpdf = new \Mpdf\Mpdf(array(
                'mode' => '',
                'format' => 'Letter',
                'default_font_size' => 0,
                'default_font' => '',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 55,
                'margin_bottom' => 30,
                'margin_header' => 5,
                'margin_footer' => 9,
                'orientation' => 'l'));
           
            $mpdf->SetHTMLFooter($num_page);
          
            $mpdf->SetHTMLFooter($num_page);
            $mpdf->SetTitle('Evaluacion Practica');
            $mpdf->SetAuthor('Qualitat');
            $mpdf->SetHTMLHeader($header);
            $mpdf->WriteHTML($style,1);
            $mpdf->WriteHTML($body ,2);
            $mpdf->SetHTMLFooter($num_page );
          
            
            $mpdf->Output();
        } 
       
    }
 
}
