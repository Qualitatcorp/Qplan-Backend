<?php

namespace app\modules\v1\models;

use Yii;

class Recursos extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'recursos';
    }

    public function rules()
    {
        return [
            [['pre_id', 'tipo'], 'required'],
            [['pre_id'], 'integer'],
            [['tipo'], 'string'],
            [['pre_id'], 'unique'],
            [['pre_id'], 'exist', 'skipOnError' => true, 'targetClass' => EvaluacionPregunta::className(), 'targetAttribute' => ['pre_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pre_id' => 'Pre ID',
            'tipo' => 'Tipo',
        ];
    }

    // public function fields()
    // {
    //     $fields = parent::fields();
    //     array_push($fields,'option','sources');
    //     return $fields;
    // }

    public function extraFields()
    {
        return ['option','options','sources'];
    }

    public function getPregunta()
    {
        return $this->hasOne(EvaluacionPregunta::className(), ['id' => 'pre_id']);
    }

    // public function getRecursosHasOptions()
    // {
    //     return $this->hasMany(RecursosHasOptions::className(), ['rec_id' => 'id']);
    // }

    public function getOptions()
    {
        // return $this->hasMany(RecursosOptions::className(), ['id' => 'opt_id'])->viaTable('recursos_has_options', ['rec_id' => 'id']);
        return RecursosOptions::findBySql('SELECT recursos_options.* FROM recursos_has_options INNER JOIN recursos_options ON (recursos_has_options.opt_id = recursos_options.id) WHERE recursos_has_options.rec_id=:id',[':id'=>$this->id])->all();
    }

    public function getOption()
    {
        $arrayOptions=[];
        foreach ($this->options as $option) {
           $key=$option->variable;
           $value=$option->valor;
           $type=$option->tipo;
           $arrayOptions[$key]=(settype($value,$type))?$value:"error : " + $value + "tipo : " + $type;
        }
        return $arrayOptions;
    }

    // public function getRecursosHasSources()
    // {
    //     return $this->hasMany(RecursosHasSources::className(), ['rec_id' => 'id']);
    // }

    public function getSources()
    {
        // return $this->hasMany(RecursosSources::className(), ['id' => 'src_id'])->viaTable('recursos_has_sources', ['rec_id' => 'id']);
    return RecursosOptions::findBySql('SELECT recursos_has_sources.* FROM `recursos_has_sources` INNER JOIN `recursos_sources` ON (`recursos_has_sources`.`src_id` = `recursos_sources`.`id`) WHERE `recursos_has_sources`.`rec_id`=:id',[':id'=>$this->id])->all();
    }
}
