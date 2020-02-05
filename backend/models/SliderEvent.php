<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%slider_event}}".
 *
 * @property int $id
 * @property int $id_event
 * @property string $img
 * @property int $event_main_page
 *
 * @property Event $event
 */
class SliderEvent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%slider_event}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_event', 'img'], 'required'],
            [['id_event', 'event_main_page'], 'integer'],
            [['img'], 'string', 'max' => 512],
            [['id_event'], 'exist', 'skipOnError' => true, 'targetClass' => Event::className(), 'targetAttribute' => ['id_event' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_event' => 'Id Event',
            'img' => 'Img',
            'event_main_page' => 'Event Main Page',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event::className(), ['id' => 'id_event']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\SliderEventQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\query\SliderEventQuery(get_called_class());
    }
}
