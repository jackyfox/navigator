<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%competence}}".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $created_at
 * @property string $deleted_at
 * @property string $updated_at
 *
 * @property ProfessionHasCompetence[] $professionHasCompetences
 * @property Profession[] $professions
 * @property ProfileHasCompetence[] $profileHasCompetences
 * @property Profile[] $profiles
 */
class Competence extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%competence}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'deleted_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 60],
            [['description'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'name' => 'Наименование',
            'description' => 'Описание',
            'created_at' => 'Создано',
            'deleted_at' => 'Архивировано',
            'updated_at' => 'Обновлено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfessionHasCompetences()
    {
        return $this->hasMany(ProfessionHasCompetence::className(), ['competence_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfessions()
    {
        return $this->hasMany(Profession::className(), ['id' => 'profession_id'])->viaTable('{{%profession_has_competence}}', ['competence_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfileHasCompetences()
    {
        return $this->hasMany(ProfileHasCompetence::className(), ['competence_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profile::className(), ['id' => 'profile_id'])->viaTable('{{%profile_has_competence}}', ['competence_id' => 'id']);
    }
}
