<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%slider_prof}}".
 *
 * @property int $id
 * @property int $id_prof
 * @property string $img_slider
 *
 * @property Profession $prof
 */
class SliderProf extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%slider_prof}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_prof', 'img_slider'], 'required'],
            [['id_prof'], 'integer'],
            [['img_slider'], 'string', 'max' => 512],
            [['id_prof'], 'exist', 'skipOnError' => true, 'targetClass' => Profession::className(), 'targetAttribute' => ['id_prof' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_prof' => 'Id Prof',
            'img_slider' => 'Img Slider',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProf()
    {
        return $this->hasOne(Profession::className(), ['id' => 'id_prof']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\SliderProfQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\query\SliderProfQuery(get_called_class());
    }
}
