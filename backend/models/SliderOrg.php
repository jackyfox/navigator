<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%slider_org}}".
 *
 * @property int $id
 * @property int $id_org
 * @property string $img_org
 *
 * @property Organisation $org
 */
class SliderOrg extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%slider_org}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_org', 'img_org'], 'required'],
            [['id_org'], 'integer'],
            [['img_org'], 'string', 'max' => 512],
            [['id_org'], 'exist', 'skipOnError' => true, 'targetClass' => Organisation::className(), 'targetAttribute' => ['id_org' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_org' => 'Id Org',
            'img_org' => 'Img Org',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrg()
    {
        return $this->hasOne(Organisation::className(), ['id' => 'id_org']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\SliderOrgQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\query\SliderOrgQuery(get_called_class());
    }
}
