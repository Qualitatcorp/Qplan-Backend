<?php

namespace app\modules\report\controllers;
use app\modules\v1\models\Ficha;
use app\modules\v1\models\PerfilModulo;
use yii\web\Controller;
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
        $num_page = " <div> <p style='width:100px; text-aling:center; margin:0 auto;'>Página {PAGENO}  de {nb} </p></div>";

        //consulta
        $ficha = Ficha::findOne($id);
        // $this->pre($ficha->ot->modpractica);

        
        // die();
        // verifica si existe
        if($ficha){
            $style=file_get_contents('http://127.0.0.1/mpdf-bootstrap.min.css');
            $report = $this->renderPartial('_practica',array('ficha'=>$ficha),true);
            $header = $this->renderPartial('_headerpractica',array('ficha'=>$ficha),true);
            $footer = $this->renderPartial('_firmaPractica');
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
            $mpdf->SetTitle('Evaluacion Practica');
            $mpdf->SetAuthor('Qualitat');
            $mpdf->SetHTMLHeader($header);
            $mpdf->WriteHTML($style,1);
            $mpdf->WriteHTML($report ,2);
            $mpdf->SetHTMLFooter($footer .$num_page );
            
            $mpdf->Output();
        }else{
           throw new \yii\web\NotFoundHttpException();
           
        }
       
    }
 
}
