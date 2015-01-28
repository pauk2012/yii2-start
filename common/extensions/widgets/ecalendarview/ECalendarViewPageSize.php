<?php

namespace common\extensions\widgets\ecalendarview;
/**
 * The page size is enumeration of possible pagination types for {@link ECalendarViewPagination}.
 */
class ECalendarViewPageSize  {

  /**
   * The month pagination.
   */
  const MONTH = 'month';

  /**
   * The week pagination.
   */
  const WEEK = 'week';

  /**
   * The day pagination.
   */
  const DAY = 'day';

  /**
   * Constructs the page size.
   */
  private function __construct() {
  }

  /**
   * Retrieves all possible values.
   * @return array The values.
   */
  public static function getValues() {
    return array(
      self::MONTH,
      self::WEEK,
      self::DAY,
    );
  }

  /**
   * Checks if the value is valid.
   * @param string $value The value.
   * @return boolean True if value belongs to enumeration, otherwise false.
   */
  public static function isValidValue($value) {
    return (boolean) in_array($value, self::getValues());
  }

}