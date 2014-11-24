<?php

namespace tests\codeception\common\unit;

use yii\helpers\ArrayHelper;

/**
 * @inheritdoc
 */
class DbTestCase extends \yii\codeception\DbTestCase
{
    public $appConfig = '@tests/codeception/config/common/unit.php';

}
