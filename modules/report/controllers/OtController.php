<?php

namespace app\modules\report\controllers;
use app\modules\v1\models\OrdenTrabajo;
use yii\web\Controller;
use SoapClient;

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

    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML('<h1>Hello world!</h1>');
    $mpdf->Output();
    
    }
    
}
