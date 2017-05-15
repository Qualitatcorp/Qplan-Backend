<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "clasificacion_perfil".
 *
 * @property string $id
 * @property integer $cla_id
 * @property string $per_id
 * @property string $acierto
 *
 * @property Clasificacion $cla
 * @property Perfil $per
 */
class Psicologicopca extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'ficha_tercero';
    }


    public function actionIndex()
    {
       return '1';
    }


    
 
}
