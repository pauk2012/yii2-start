<?php

namespace common\extensions\widgets\ecalendarview;
use yii\base\Component;
use DateInterval;

/**
 * The data provider prepares data to be shown by {@link ECalendarView}.
 */
class ECalendarViewDataProvider extends Component {

  /**
   * @var ECalendarViewPagination The pagination.
   */
  private $_pagination;

  /**
   * Constructs the data provider and sets it's attributes to default values.
   * @param array $config The attributes as key=>value map.
   */
  public function __construct(array $config = array()) {
    $this->_pagination = new ECalendarViewPagination();

    foreach($config as $key => $value) {
      $this->$key = $value;
    }
  }

  /**
   * Sets the pagination's attributes.
   * @param array $config The attributes as key=>value map.
   */
  public function setPagination(array $config) {
    foreach($config as $key => $value) {
      $this->getPagination()->$key = $value;
    }
  }

  /**
   * @see ECalendarViewDataProvider::$_pagination
   */
  public function getPagination() {
    return $this->_pagination;
  }

  /**
   * Retrieves the data.
   * @return array The array of {@link ECalendarViewItem}s.
   */
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
        ));
      $dateIterator->add(new DateInterval('P1D'));
    }

    return $data;
  }

  public function getModels()
  {
    $this->dataSource->getModels();
  }

}
