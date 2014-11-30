<?php

namespace common\extensions\behaviors;

use yii\db\BaseActiveRecord;
use yii\behaviors\AttributeBehavior;
use yii\db\Expression;

class OwnerBehavior extends AttributeBehavior
{
    /**
     * @var string the attribute that will receive owner_id value
     * Set this property to false if you do not want to record the creation user_id.
     */
    public $createdByAttribute = 'created_by';
    public $value;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => [$this->createdByAttribute],
                //BaseActiveRecord::EVENT_BEFORE_UPDATE => $this->updatedByAtAttribute,
            ];
        }
    }

    /**
     * @inheritdoc
     */
    protected function getValue($event)
    {
        $isNewOwner = true;
        $owner = $this->owner;
        if (!$owner->getIsNewRecord() && !empty($owner->{$this->createdByAttribute})) {
            $isNewOwner = false;
        }
        if (is_null(\Yii::$app->user->id)){
            $isNewOwner = false;
        }
        if ($isNewOwner){
            return \Yii::$app->user->id;
        } else {
            return $this->owner->{$this->createdByAttribute};
        }

        //return parent::getValue($event);
    }

    /**
     * Updates a timestamp attribute to the current timestamp.
     *
     * ```php
     * $model->touch('lastVisit');
     * ```
     * @param string $attribute the name of the attribute to update.
     */
    public function touch($attribute)
    {
        $this->owner->updateAttributes(array_fill_keys((array) $attribute, $this->getValue(null)));
    }
}
