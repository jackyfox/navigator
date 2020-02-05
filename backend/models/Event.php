<?php

namespace backend\models;

use Yii;
//use yii\validators\FileValidator;
//use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%event}}".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $picture
 * @property string $event_time
 *
 * @property EventHasAddress[] $eventHasAddresses
 * @property Address[] $addresses
 * @property EventHasOrganisation[] $eventHasOrganisations
 * @property ProfileFavoriteEvent[] $profileFavoriteEvents
 * @property ProfileHasNotification[] $profileHasNotifications
 * @property SliderEvent[] $sliderEvents
 */
class Event extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    /**
     * @var Event[]
     */
    public $file;
    public $sliderFiles;

    public static function tableName()
    {
        return '{{%event}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
        	[['file'], 'file'/*, 'extensions'=>'jpg, jpeg, gif, png', 'maxFiles' => 1*/],
            [['sliderFiles'], 'file', 'maxFiles' => 10,/*'extensions' => 'png, jpg','checkExtensionByMimeType'=>false*/],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 45],
            //[['picture'], 'required'],
            [['picture'], 'string', 'max' => 512],
            [['event_time'], 'safe'],
            [['addressesArray'], 'safe'],
            [['organisationArray'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'title' => 'Заголовок',
            'description' => 'Описание',
            'event_time'=>'Дата,время проведения',
            'addressesArray' => 'Адреса',
            'organisationArray'=>'Задействованные в событии организации',
            'picture' =>'Адрес картинки',
            'file'=>'Картинка',
            'sliderFiles'=>'Изображения слайдера',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventHasAddresses()
    {
        return $this->hasMany(EventHasAddress::className(), ['event_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Address::className(), ['id' => 'address_id'])->viaTable('{{%event_has_address}}', ['event_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventHasOrganisation()
    {
        return $this->hasMany(EventHasOrganisation::className(), ['id_event' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganisation()
    {
        return $this->hasMany(Organisation::className(), ['id' => 'id_org'])->viaTable('{{%event_has_organisation}}', ['id_event' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfileFavoriteEvents()
    {
        return $this->hasMany(ProfileFavoriteEvent::className(), ['id_event' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfileHasNotifications()
    {
        return $this->hasMany(ProfileHasNotification::className(), ['id_event' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSliderEvents()
    {
        return $this->hasMany(SliderEvent::className(), ['id_event' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\EventQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\query\EventQuery(get_called_class());
    }
        // Работа с Адресами 
    private $_addressesArray;

    public function getAddressesArray()
    {
        if ($this->_addressesArray === null) {
            $this->_addressesArray = $this->getAddresses()->select('id')->column();
        }
        return $this->_addressesArray;
    }

    public function setAddressesArray($value)
    {
        $this->_addressesArray = (array)$value;
    }
    private function updateAddresses()
    {
        $currentAddressIds = $this->getAddresses()->select('id')->column();
        $newAddressIds = $this->getAddressesArray();

        foreach (array_filter(array_diff($newAddressIds, $currentAddressIds)) as $addressId) {
            /** @var Address $address */
            if ($address = Address::findOne($addressId)) {
                $this->link('addresses', $address);
            }
        }

        foreach (array_filter(array_diff($currentAddressIds, $newAddressIds)) as $addressId) {
            /** @var Address $address */
            if ($address = Address::findOne($addressId)) {
                $this->unlink('addresses', $address, true);
            }
        }
    }

    //Работа с организацииями
    private $_organisationArray;

    public function getOrganisationArray()
    {
        if ($this->_organisationArray === null) {
            $this->_organisationArray = $this->getOrganisation()->select('id')->column();
        }
        return $this->_organisationArray;
    }

    public function setOrganisationArray($value)
    {
        $this->_organisationArray = (array)$value;
    }
    private function updateOrganisation()
    {
        $currentOrganisationIds = $this->getOrganisation()->select('id')->column();
        $newOrganisationIds = $this->getOrganisationArray();

        foreach (array_filter(array_diff($newOrganisationIds, $currentOrganisationIds)) as $addressId) {
            
            if ($organisation = Organisation::findOne($addressId)) {
                $this->link('organisation', $organisation);
            }
        }

        foreach (array_filter(array_diff($currentOrganisationIds, $newOrganisationIds)) as $addressId) {
            
            if ($organisation = Organisation::findOne($addressId)) {
                $this->unlink('organisation', $organisation, true);
            }
        }
    }

    public function uploadSlider()
    {   
        if ($this->validate()) {
             
            foreach ($this->sliderFiles as $sliderFile) {
                $slider = new SliderEvent;
                $imageName = Yii::$app->getSecurity()->generateRandomString(5)."_".time();
                $link = 'upload/event/'.$this->id.'/slider/events_'.$imageName.'.'.$sliderFile->extension;
                $sliderFile->saveAs('../../frontend/web/'.$link);
                if (file_exists($_SERVER['DOCUMENT_ROOT']."/frontend/web/".$link)) {
                    $slider = new SliderEvent;
                    $slider->id_event = $this->id;
                    $slider->img = $link;
                    $slider->event_main_page = 0;
                    $slider->save();
                    unset($slider);
                }
            }

            /*
            Более изошрённый способ но рабочий
            $sliderArr = [];
            for ($i=0; $i < count($this->sliderFiles); $i++) { 
                $sliderFile = $this->sliderFiles[$i];
                $imageName = Yii::$app->getSecurity()->generateRandomString(5)."_".time();
                $link = 'upload/event/'.$this->id.'/slider/events_'.$imageName.'.'.$sliderFile->extension;
                $sliderFile->saveAs('../../frontend/web/'.$link);
                if (file_exists($_SERVER['DOCUMENT_ROOT']."/frontend/web/".$link)) {
                    $sliderArr[] = $link;
                }
            }


            for ($i=0; $i < count($sliderArr); $i++) {
                $slider = new SliderEvent;
                $slider->id_event = $this->id;
                $slider->img = $sliderArr[$i];
                $slider->event_main_page = 0;
                $slider->save();
            }*/
            return true;
        } else {
            return false;
        }
    }

    // afterSave
    public function afterSave($insert, $changedAttributes)
    {
        $this->updateAddresses();
        $this->updateOrganisation();
        parent::afterSave($insert, $changedAttributes);
    }

}
