<?php

namespace backend\models;

use Yii;
//use yii\validators\FileValidator;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use backend\models\query\ProfessionQuery;
/**
 * This is the model class for table "profession".
 *
 * @property int $id
 * @property string $name
 * @property string $short_desc
 * @property string $description
 * @property string $img
 * @property int $low_salary
 * @property int $high_salary
 * @property string $created_at
 * @property string $deleted_at
 * @property string $updated_at
 *
 * @property ClusterHasProfession[] $clusterHasProfessions
 * @property Cluster[] $clusters
 * @property OrganisationHasProfession[] $organisationHasProfessions
 * @property Organisation[] $organisations
 * @property ProfessionHasCompetence[] $professionHasCompetences
 * @property Competence[] $competences
 * @property SliderProf[] $sliderProfs
 */
class Profession extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profession';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file'], 'file'/*,'extensions'=>'jpg, jpeg, gif, png', 'maxFiles' => 1*/],
            [['description'], 'string'],
            //[['img'], 'required'],
            [['low_salary', 'high_salary'], 'integer'],
            [['created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 60],
            [['video'], 'string', 'max' => 512],
            [['short_desc'], 'string', 'max' => 255],
            [['img'], 'string', 'max' => 512],
            [['name'], 'unique'],
            [['competencesArray'], 'safe'],
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
            'short_desc' => 'Короткое описание',
            'description' => 'Полное описание',
            'img' => 'Адресс картинки',
            'file'=>'Картинка',
            'low_salary' => 'Минимальная з.п',
            'high_salary' => 'Максимальная з.п',
            'competencesArray'=>'Компитенции',
            'created_at' => 'Создано',
            'deleted_at' => 'Архивировано',
            'updated_at' => 'Обновлено',
            'video'=>'Ссылка на видос',

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClusterHasProfessions()
    {
        return $this->hasMany(ClusterHasProfession::className(), ['profession_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClusters()
    {
        return $this->hasMany(Cluster::className(), ['id' => 'cluster_id'])->viaTable('cluster_has_profession', ['profession_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganisationHasProfessions()
    {
        return $this->hasMany(OrganisationHasProfession::className(), ['profession_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganisations()
    {
        return $this->hasMany(Organisation::className(), ['id' => 'organisation_id'])->viaTable('organisation_has_profession', ['profession_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfessionHasCompetences()
    {
        return $this->hasMany(ProfessionHasCompetence::className(), ['profession_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetences()
    {
        return $this->hasMany(Competence::className(), ['id' => 'competence_id'])->viaTable('profession_has_competence', ['profession_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSliderProf()
    {
        return $this->hasMany(SliderProf::className(), ['id_prof' => 'id']);
    }


    /**
     * @inheritdoc
     * @return ProfessionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProfessionQuery(get_called_class());
    }
        // Работа с Адресами 
    private $_competencesArray;

    public function getCompetencesArray()
    {
        if ($this->_competencesArray === null) {
            $this->_competencesArray = $this->getCompetences()->select('id')->column();
        }
        return $this->_competencesArray;
    }

    public function setCompetencesArray($value)
    {
        $this->_competencesArray = (array)$value;
    }
    private function updateCompetences()
    {
        $currentCompetenceIds = $this->getCompetences()->select('id')->column();
        $newCompetenceIds = $this->getCompetencesArray();

        foreach (array_filter(array_diff($newCompetenceIds, $currentCompetenceIds)) as $competenceId) {
            if ($competence = Competence::findOne($competenceId)) {
                $this->link('competences', $competence);
            }
        }

        foreach (array_filter(array_diff($currentCompetenceIds, $newCompetenceIds)) as $competenceId) {
            /** @var Address $address */
            if ($competence = Competence::findOne($competenceId)) {
                $this->unlink('competences', $competence, true);
            }
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->updateCompetences();
        parent::afterSave($insert, $changedAttributes);
    }
}
