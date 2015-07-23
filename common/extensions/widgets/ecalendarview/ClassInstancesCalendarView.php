<?php

namespace common\extensions\widgets\ecalendarview;


use common\extensions\widgets\ecalendarview\ViewDataProviders\ClassInstances;
use yii\base\Controller;
use yii\base\Widget;
use yii\helpers\Json;
use yii\helpers\Url;

/**
 * The calendar view renders days using customizable view.
 */
class ClassInstancesCalendarView extends ECalendarView {

  public $sourceHref;
  public function __construct($config = []) {

    $this->setDataProvider(['class' => ClassInstances::className()]);
    parent::__construct($config);

  }


}
