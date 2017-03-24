<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "clasificacion".
 *
 * @property integer $id
 * @property integer $cat_id
 * @property string $nombre
 *
 * @property ClasificacionCategoria $cat
 * @property ClasificacionPerfil[] $clasificacionPerfils
 * @property Perfil[] $pers
 * @property EmpresaClasificacion[] $empresaClasificacions
 */

class Clasificacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clasificacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_id', 'nombre'], 'required'],
            [['cat_id'], 'integer'],
            [['nombre'], 'string', 'max' => 128],
            [['cat_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClasificacionCategoria::className(), 'targetAttribute' => ['cat_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_id' => 'Cat ID',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCat()
    {
        return $this->hasOne(ClasificacionCategoria::className(), ['id' => 'cat_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClasificacionPerfils()
    {
        return $this->hasMany(ClasificacionPerfil::className(), ['cla_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPers()
    {
        return $this->hasMany(Perfil::className(), ['id' => 'per_id'])->viaTable('clasificacion_perfil', ['cla_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresaClasificacions()
    {
        return $this->hasMany(EmpresaClasificacion::className(), ['cla_id' => 'id']);
    }
}
