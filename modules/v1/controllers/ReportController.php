<?php 

namespace app\modules\v1\controllers;

use yii;
use app\models\user\User;
use yii\rest\Controller;
use kartik\mpdf\Pdf;
class ReportController extends Controller
{

	public function actionIndex()
	{
		$pdf = Yii::$app->pdf;
		$pdf->content = "Daniel";
		return $pdf->render();
   }
 
	 
}

