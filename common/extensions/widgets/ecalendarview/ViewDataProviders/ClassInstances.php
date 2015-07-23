<?php


namespace common\extensions\widgets\ecalendarview\ViewDataProviders;

use common\extensions\widgets\ecalendarview\ECalendarViewDataProvider;
use common\extensions\widgets\ecalendarview\ECalendarViewItem;
use DateInterval;
use yii\helpers\Url;


/**
 * The data provider prepares data to be shown by {@link ECalendarView}.
 */
class ClassInstances extends ECalendarViewDataProvider {

    private $_source;

  public function getData() {
    $data = array();
    $startDate = $this->getPagination()->getFirstPageDate();
    $endDate = $this->getPagination()->getLastPageDate();
    $dateIterator = clone($startDate);

    while($dateIterator <= $endDate) {
      $data[] = new ECalendarViewItem(array(
          'date' => clone($dateIterator),
          'isCurrentDate' => $this->getPagination()->isCurrentDate($dateIterator),
          'isRelevantDate' => $this->getPagination()->isRelevantDate($dateIterator),
     //     'source' =>  ['href' => Url::to(['classes','id' => ])

        ));
      $dateIterator->add(new DateInterval('P1D'));
    }

    return $data;
  }

}
