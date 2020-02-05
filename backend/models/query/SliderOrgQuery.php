<?php

namespace backend\models\query;

/**
 * This is the ActiveQuery class for [[\backend\models\SliderOrg]].
 *
 * @see \backend\models\SliderOrg
 */
class SliderOrgQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \backend\models\SliderOrg[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\SliderOrg|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
