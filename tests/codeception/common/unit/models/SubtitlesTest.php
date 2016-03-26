<?php
/**
 * @TODO move to backend tests
 */
namespace tests\codeception\common\unit\models;

use GuzzleHttp\Client;
use tests\codeception\common\unit\TestCase;
use Yii;
use pauko\billingual\models\Spanish;
use yii\base\Component;
use yii\base\Exception;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;


class SubtitlesTest extends TestCase
{

    use \Codeception\Specify;



    public function setUp()
    {
    //    $this->markTestSkipped('must be revisited');

    }



    public function testSrt()
    {

        $this->assertEquals(Spanish::find('preguntar')['root'], 'pregunt');


      //  require('src/SrtParser/srtFile.php');

        try{
            $file = new \SrtParser\srtFile(dirname(__FILE__) . '/Spotlight.DVDScr.CM8.en.srt');
            $fileBg = new \SrtParser\srtFile(dirname(__FILE__) . '/Spotlight.2015.BRRip.x264-WAR.srt', 'windows-1251');

            $firstSub = $file->getSub(3);

            $firstSubBg = $fileBg->getSub(2);
            \Codeception\Util\Debug::debug($firstSub->getText());
            \Codeception\Util\Debug::debug($firstSubBg->getText());
            $fileBg->shift($firstSub->getStart() - $firstSubBg->getStart() );

            $file->mergeSrtFile($fileBg);
            // display the text of the first entry


            for ($i=0;  $i<($file->getSubCount()); $i++){
               $text = $file->getSub($i)->getText() . ' ' . $file->getSub($i)->getTimeCodeString();
                //$text = iconv("windows-1252", "utf-8", $text );
                //$text =  mb_convert_encoding($text,  "utf-8", "windows-1251");
                \Codeception\Util\Debug::debug($text);
            }


            #\Codeception\Util\Debug::debug(mb_convert_encoding("Íàèñòèíà ëè? Çàùî?",  "utf-8", "windows-1251"));

            //\Codeception\Util\Debug::debug($file->getSubCount());







        }
        catch(Exception $e){
            echo 'Error: '.$e->getMessage()."\n";
        }
    }

    public function testMoviesubtitlesOrg()
    {
        $url = "http://www.moviesubtitles.org/search.php";
        //q=bridge+of+spies

        $requestParams = ['q' => 'bridje+of+spies'];
        $client = new Client();
        $response = $client->get($url,['body' => $requestParams]);
        \Codeception\Util\Debug::debug( $response->xml());

    }


}

