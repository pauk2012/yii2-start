<?php
/**
 * @TODO move to backend tests
 */
namespace tests\codeception\common\unit\models;


use GuzzleHttp\Client;
use pauko\billingual\clients\GoogleTranslate;
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
    /**
     * @var /RemoteWebDriver
     */
    private $driver;
    use \Codeception\Specify;




    public function testTranslate()
    {

// An example of using php-webdriver.

        //require_once('lib/__init__.php');

// start Firefox with 5 second timeout
        $host = 'http://localhost:4444/wd/hub'; // this is the default
        $capabilities = \DesiredCapabilities::firefox();


        $driver = \RemoteWebDriver::create($host, $capabilities, 5000);
        $driver->get('https://translate.google.com');

        $sourceText = $driver->findElement(
            \WebDriverBy::id('source')
        );



        $this->assertContains('Detect', $driver->findElement(\WebDriverBy::xpath('.//div[@id="gt-sl-sugg"]/div[@value="auto"]'))->getText());


        $sourceText->sendKeys('hablar');

        //$driver->wait()->until(\WebDriverExpectedCondition::textToBePresentInElement();
        $driver->wait()->until(\WebDriverExpectedCondition::presenceOfElementLocated(\WebDriverBy::xpath('.//span[@id="result_box"]/span')));
        $spanWithTranslatedText = $driver->findElement(\WebDriverBy::xpath('.//span[@id="result_box"]/span'));


        $this->assertEquals('Spanish - detected', $driver->findElement(\WebDriverBy::xpath('.//div[@id="gt-sl-sugg"]/div[@value="auto"]'))->getText());
        $this->assertEquals('talk', $driver->findElement(\WebDriverBy::xpath('.//span[@id="result_box"]/span'))->getText());

        $sourceText->clear();

        $driver->wait()->until(\WebDriverExpectedCondition::stalenessOf($spanWithTranslatedText));



        $driver->close();


    }


    public function testPregReplace()
    {

      $this->assertEquals(1, preg_match('/(\w+)\s-\sdetected/', 'Spanish - detected', $matches));
        $this->assertEquals('Spanish', $matches[1]);

    }

    public function testGoogleTranslateClient()
    {
        $client = new GoogleTranslate();
        $client->setCloseDriverAfterDestructEnabled(false);
        $this->assertEquals('talk', $client->translateText('hablar'));
        $this->assertEquals('es', $client->resolveDetectedLanguage());

        $this->assertEquals('talk', $client->translateText('беседовать'));
        $this->assertEquals('ru', $client->resolveDetectedLanguage());


        $fileName = dirname(__FILE__) . '/Spotlight.DVDScr.CM8.en.srt';
        $client->translateFilePartialy($fileName);
        $this->assertEquals('en', $client->resolveDetectedLanguage());



        $fileName = dirname(__FILE__) . '/Spotlight.2015.BRRip.x264-WAR_UTF8.srt';
        $client->translateFilePartialy($fileName, 500);

        $this->assertEquals('bg', $client->resolveDetectedLanguage());

        $fileName = dirname(__FILE__) . '/Bridge_Of_Spies_RUS_2015_20160203181646-UTF8.srt';
        $client->translateFilePartialy($fileName, 500);
        $this->assertEquals('ru', $client->resolveDetectedLanguage());


    }




}

