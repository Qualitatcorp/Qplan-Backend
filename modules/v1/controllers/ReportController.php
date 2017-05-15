<?php 

namespace app\modules\v1\controllers;

use yii;
use app\models\user\User;
use yii\rest\Controller;
use kartik\mpdf\Pdf;
class ReportController extends Controller
{
	public function actions()
	{
	    $actions = parent::actions();

	    // disable the "delete" and "create" actions
	    unset($actions['create'],$actions['index']);

	     
	    return $actions;
	}

	public function actionIndex()
	{
		$content = 's';
		$content .= '<div class="container ">S</div>';

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
        'cssInline' => '.kv-heading-1{font-size:16px}', 
         // set mPDF properties on the fly
        'options' => ['title' => 'Drr'],
         // call mPDF methods on the fly
        'methods' => [ 
            'SetHeader'=>['Qplan Report Header'], 
            'SetFooter'=>['{PAGENO}'],
        ]
    ]);
    return $pdf->render(); 
   }
 
	 
}

?>
