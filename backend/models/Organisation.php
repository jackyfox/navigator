<?php

namespace backend\models;

use Yii;
//use yii\validators\FileValidator;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use backend\models\query\OrganisationQuery;
/**
 * This is the model class for table "organisation".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $img
 *
 * @property OrganisationHasAddress[] $organisationHasAddresses
 * @property OrganisationHasPersonality[] $organisationHasPersonalities
 * @property Personality[] $personalities
 * @property OrganisationHasProfession[] $organisationHasProfessions
 * @property Profession[] $professions
 * @property OrganisationHasType[] $organisationHasTypes
 * @property Type[] $type
 */
class Organisation extends ActiveRecord
{   
    public $file;
    public $fileLogo;
    public $sliderFiles;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%organisation}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file'], 'file'/*, 'extensions'=>'jpg, jpeg, gif, png', 'maxFiles' => 1*/],
            [['fileLogo'], 'file'/*, 'extensions'=>'jpg, jpeg, gif, png', 'maxFiles' => 1*/],
            [['sliderFiles'], 'file', 'maxFiles' => 10,/*'extensions' => 'png, jpg','checkExtensionByMimeType'=>false*/],
            [['description'], 'string'],
            //[['img'], 'required'],
            [['name'], 'string', 'max' => 120],
            [['img'], 'string', 'max' => 512],
            [['name'], 'unique'],
            //[['logo'], 'required'],
            [['logo'], 'string', 'max' => 512],
            [['video'], 'string', 'max' => 512],
            [['typesArray'], 'safe'],
            [['addressesArray'], 'safe'],
            [['professionsArray'], 'safe'],
            [['personalitiesArray'], 'safe'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'name' => 'Название',
            'description' => 'Описание',
            'img' => 'Адрес картинки',
            'file'=>'Картинкa',
            'logo'=>'Адрес логотипа',
            'fileLogo'=>'Логотип',
            'typesArray' => 'Типы',
            'addressesArray' => 'Адреса',
            'professionsArray' => 'Профессии',
            'personalitiesArray' => 'Лица для отображения в компании',
            'video'=>'Ссылка на видос',
            'sliderFiles'=>'Добавление зображений слайдера',
            
        ];
    }
  

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganisationHasAddresses()
    {
        return $this->hasMany(OrganisationHasAddress::className(), ['organisation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganisationHasPersonalities()
    {
        return $this->hasMany(OrganisationHasPersonality::className(), ['organisation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonalities()
    {
        return $this->hasMany(Personality::className(), ['id' => 'personality_id'])->viaTable('organisation_has_personality', ['organisation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganisationHasProfessions()
    {
        return $this->hasMany(OrganisationHasProfession::className(), ['organisation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfessions()
    {
        return $this->hasMany(Profession::className(), ['id' => 'profession_id'])->viaTable('organisation_has_profession', ['organisation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganisationHasTypes()
    {
        return $this->hasMany(OrganisationHasType::className(), ['organisation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypes()
    {
        return $this->hasMany(Type::className(), ['id' => 'type_id'])->viaTable('{{%organisation_has_type}}', ['organisation_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Address::className(), ['id' => 'address_id'])->viaTable('{{%organisation_has_address}}', ['organisation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSliderOrg()
    {
        return $this->hasMany(SliderOrg::className(), ['id' => 'id_org']);
    }


    /**
     * @inheritdoc
     * @return OrganisationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrganisationQuery(get_called_class());
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


    // Работа с Типами учреждений 
    private $_typesArray;

    public function getTypesArray()
    {
        if ($this->_typesArray === null) {
            $this->_typesArray = $this->getTypes()->select('id')->column();
        }
        return $this->_typesArray;
    }

    public function setTypesArray($value)
    {
        $this->_typesArray = (array)$value;
    }
    private function updateTypes()
    {
        $currentTypeIds = $this->getTypes()->select('id')->column();
        $newTypeIds = $this->getTypesArray();

        foreach (array_filter(array_diff($newTypeIds, $currentTypeIds)) as $typeId) {
            /** @var Type $type */
            if ($type = Type::findOne($typeId)) {
                $this->link('types', $type);
            }
        }

        foreach (array_filter(array_diff($currentTypeIds, $newTypeIds)) as $typeId) {
            /** @var Type $type */
            if ($type = Type::findOne($typeId)) {
                $this->unlink('types', $type, true);
            }
        }
    }

    // Работа с Профессиями 
    private $_professionsArray;

    public function getProfessionsArray()
    {
        if ($this->_professionsArray === null) {
            $this->_professionsArray = $this->getProfessions()->select('id')->column();
        }
        return $this->_professionsArray;
    }

    public function setProfessionsArray($value)
    {
        $this->_professionsArray = (array)$value;
    }
    private function updateProfessions()
    {
        $currentProfessionIds = $this->getProfessions()->select('id')->column();
        $newProfessionIds = $this->getProfessionsArray();

        foreach (array_filter(array_diff($newProfessionIds, $currentProfessionIds)) as $professionId) {
            // @var Profession $profession 
            if ($profession = Profession::findOne($professionId)) {
                $this->link('professions', $profession);
            }
        }

        foreach (array_filter(array_diff($currentProfessionIds, $newProfessionIds)) as $professionId) {
            //@var Profession $profession 
            if ($profession = Profession::findOne($professionId)) {
                $this->unlink('professions', $profession, true);
            }
        }
    }

    // Работа с Рожами
    private $_personalitiesArray;

    public function getPersonalitiesArray()
    {
        if ($this->_personalitiesArray === null) {
            $this->_personalitiesArray = $this->getPersonalities()->select('id')->column();
        }
        return $this->_personalitiesArray;
    }

    public function setPersonalitiesArray($value)
    {
        $this->_personalitiesArray = (array)$value;
    }
    private function updatePersonalities()
    {
        $currentPersonalitiesIds = $this->getPersonalities()->select('id')->column();
        $newPersonalitiesIds = $this->getPersonalitiesArray();

        foreach (array_filter(array_diff($newPersonalitiesIds, $currentPersonalitiesIds)) as $personalitiesId) {

            if ($personalities = Personalities::findOne($personalitiesId)) {
                $this->link('personalities', $personalities);
            }
        }

        foreach (array_filter(array_diff($currentPersonalitiesIds, $newPersonalitiesIds)) as $personalitiesId) {

            if ($personalities = Personalities::findOne($personalitiesId)) {
                $this->unlink('personalities', $personalities, true);
            }
        }
    }

    public function uploadSliderOrg()
    {   
        if ($this->validate()) {
             
            foreach ($this->sliderFiles as $sliderFile) {
                $slider = new SliderOrg;
                $imageName = Yii::$app->getSecurity()->generateRandomString(5)."_".time();
                $link = 'upload/organisation/'.$this->id.'/slider/org_'.$imageName.'.'.$sliderFile->extension;
                $sliderFile->saveAs('../../frontend/web/'.$link);
                if (file_exists($_SERVER['DOCUMENT_ROOT']."/frontend/web/".$link)) {
                    $slider = new SliderOrg;
                    $slider->id_org = $this->id;
                    $slider->img_org = $link;
                    $slider->save();
                    unset($slider);
                }
            }
            return true;
        } else {
            return false;
        }
    }



    public function afterSave($insert, $changedAttributes)
    {
        $this->updateAddresses();
        $this->updateTypes();
        $this->updateProfessions();
        parent::afterSave($insert, $changedAttributes);
    }
}
