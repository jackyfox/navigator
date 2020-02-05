<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%address}}".
 *
 * @property int $id
 * @property string $coords
 * @property string $st_addr
 *
 * @property EventHasAddress[] $eventHasAddresses
 * @property Event[] $events
 * @property OrganisationHasAddress[] $organisationHasAddresses
 * @property Organisation[] $organisations
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%address}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['coords'], 'required'],
            [['coords'],'string', 'max' => 255],
            [['st_addr'], 'required'],
            [['st_addr'],'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'coords' => 'Координаты',
            'st_addr' => 'Адрес',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventHasAddresses()
    {
        return $this->hasMany(EventHasAddress::className(), ['address_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Event::className(), ['id' => 'event_id'])->viaTable('{{%event_has_address}}', ['address_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganisationHasAddresses()
    {
        return $this->hasMany(OrganisationHasAddress::className(), ['address_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganisation()
    {
        return $this->hasMany(Address::className(), ['id' => 'address_id'])->viaTable('{{%organisation_has_address}}', ['organisation_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\AddressQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\query\AddressQuery(get_called_class());
    }
}
