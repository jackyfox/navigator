<?php

namespace backend\models\query;

/**
 * This is the ActiveQuery class for [[\backend\models\Organisation]].
 *
 * @see \backend\models\Organisation
 */
class OrganisationQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \backend\models\Organisation[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\Organisation|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
