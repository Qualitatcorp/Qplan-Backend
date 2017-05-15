<?php

namespace app\modules\report\controllers;
use app\modules\v1\models\OrdenTrabajo;
use yii\web\Controller;
use kartik\mpdf\Pdf;

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

    public function actionIndex()
    {

    
    //$model = OrdenTrabajo::findOne(1);
    //
     echo "<pre>";
   
    //$t = OrdenTrabajo::find(1)->with(['trabajador','especialidad'])->asArray()->One();
    
    $t = OrdenTrabajo::find(1)->with(['trabajador','especialidad'])->One();
    print_r($t);
    
    echo "<pre>";
    die();
    $content = $this->renderPartial('_report',array(
       'trabajador'=>$trabajador,
    ));
   
   	
    $pdf = new Pdf([
       
        // A4 paper format
        'format' => Pdf::FORMAT_A4, 
        // portrait orientation
        'orientation' => Pdf::ORIENT_PORTRAIT, 
        // stream to browser inline
        'destination' => Pdf::DEST_BROWSER, 
        // your html content input
        'content' => $content,  
        // format content from your own css file if needed or use the
        // enhanced bootstrap css built by Krajee for mPDF formatting 
        'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
        // any css to be embedded if required
        'cssInline' => '.kv-heading-1{font-size:18px}', 
         // set mPDF properties on the fly
        'options' => ['title' => 'Krajee Report Title'],
         // call mPDF methods on the fly
        'methods' => [ 
            'SetHeader'=>[''], 
            'SetFooter'=>['{PAGENO}'],
        ]
    ]);
 
    // return the pdf output as per the destination setting
    //return $content; 
    return $pdf->render();
    }
    
}
