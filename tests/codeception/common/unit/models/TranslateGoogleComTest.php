<?php
/**
 * @TODO move to backend tests
 */
namespace tests\codeception\common\unit\models;


use GuzzleHttp\Client;
use pauko\Diff\Diff;
use pauko\Diff\Renderer\Html\ArrayRenderer;
use pauko\Diff\Renderer\Html\Inline;
use pauko\Diff\Renderer\Html\SideBySide;
use pauko\Diff\Renderer\Text\Context;
use pauko\Diff\Renderer\Text\Unified;
use tests\codeception\common\unit\TestCase;
use Yii;
use pauko\billingual\models\Spanish;
use yii\base\Component;
use yii\base\Exception;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;
use Zelenin\yii\SemanticUI\modules\Sidebar;


class TranslateGoogleComTest extends TestCase
{

    use \Codeception\Specify;




    public function testParse()
    {

// An example of using php-webdriver.

        //require_once('lib/__init__.php');

// start Firefox with 5 second timeout
        $host = 'http://localhost:4444/wd/hub'; // this is the default
        $capabilities = \DesiredCapabilities::firefox();
        $driver = \RemoteWebDriver::create($host, $capabilities, 5000);

// navigate to 'http://docs.seleniumhq.org/'
        $driver->get('http://docs.seleniumhq.org/');


    }




}

