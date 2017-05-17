<?php

namespace app\modules\v1\models;
use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

/**
 * This is the model class for table "recursos_sources".
 *
 * @property string $id
 * @property string $src
 * @property string $type
 * @property string $title
 *
 * @property RecursosHasSources[] $recursosHasSources
 * @property Recursos[] $recs
 */

class RecursosSources extends \yii\db\ActiveRecord
{
    
    public $file;
    public static function tableName()
    {
        return 'recursos_sources';
    }


    public function rules()
    {
        return [
            [['src', 'type'], 'required'],
            [['type'], 'string'],
            [['src'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 256],
            [['src'], 'unique'],
           
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'src' => 'Src',
            'type' => 'Type',
            'title' => 'Title',
        ];
    }

    // public function fields()
    // {
    //     return ['src','type','title'];
    // }

    // public function getRecursosHasSources()
    // {
    //     return $this->hasMany(RecursosHasSources::className(), ['src_id' => 'id']);
    // }

    public function getRecursos()
    {
        return $this->hasMany(Recursos::className(), ['id' => 'rec_id'])->viaTable('recursos_has_sources', ['src_id' => 'id']);
    }
     public function upload()
    {
        $file = $this->file[0]; //el parametro esta definido para recibir mas de un archivo, pero trabajaremos con uno 
        $this->src = \Yii::$app->security->generateRandomString(); 
        $this->type =  $file->type;
        $this->title = $file->baseName;
        if($this->save()){
            $nombre = $this->id.'-'.\Yii::$app->security->generateRandomString(). '.' . $file->extension;
            $ruta_guardado  = '../..'.\Yii::$app->params['url_frontend'].'/src/' . $nombre;
            $src = \Yii::$app->params['url_frontend'].'/src/' . $nombre;
            $file->saveAs($ruta_guardado);
            $this->src = $src;
            $this->save();
            return true;
        }else{
            return false;
        }    
       
     
 

    }
}
