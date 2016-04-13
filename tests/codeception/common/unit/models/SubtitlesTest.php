<?php
/**
 * @TODO move to backend tests
 */
namespace tests\codeception\common\unit\models;

use GuzzleHttp\Client;
use pauko\billingual\helpers\Utils;
use SrtParser\srtFileEntry;
use tests\codeception\common\unit\TestCase;
use tests\codeception\console\unit\DbTestCase;
use Yii;
use pauko\billingual\models\Spanish;
use yii\base\Component;
use yii\base\Exception;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;


class SubtitlesTest extends DbTestCase
{

    use \Codeception\Specify;



    public function setUp()
    {


    //    $this->markTestSkipped('must be revisited');


    }



    public function testSrt()
    {

        try{
            $file = new \SrtParser\srtFile(dirname(__FILE__) . '/../data/Spotlight.DVDScr.CM8.en.srt');
            $fileBg = new \SrtParser\srtFile(dirname(__FILE__) . '/../data/Spotlight.2015.BRRip.x264-WAR.srt', 'windows-1251');

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

    public function testSort()
    {
        $subFile = new \SrtParser\srtFile(dirname(__FILE__) . '/../data/subtitles.unsorted.en.srt');


        $subFile->sortSubs();
        $subtitles = $subFile->getSubs();
        $this->assertEquals('text1', $subFile->getSubs()[0]->getText());
        $this->assertEquals('text2', $subFile->getSubs()[1]->getText());
        $this->assertEquals('text4', $subFile->getSubs()[2]->getText());
        $this->assertEquals('text3', $subFile->getSubs()[3]->getText());
    }

    public function testSyncTranslationsPairs()
    {
        /*
        $this->mockApplication();
        $db = Yii::$app->db;
        $db->createCommand("delete from _subtitles")->execute();
        */



        $subFile = new \SrtParser\srtFile(dirname(__FILE__) . '/../data/subtitles.overlapped.en.srt');
        $this->assertEquals(6,count($subFile->getSubs()));
        $subFile->mergeOverlaps();


        $this->assertEquals(4,count($subFile->getSubs()));
        $this->assertEquals('text1',$subFile->getSubs()[0]->getText());
        $this->assertEquals("text3_overlapped\ntext4_overlapped",$subFile->getSubs()[2]->getText());
        $this->assertEquals("text6_overlapped\ntext5_overlapped",$subFile->getSubs()[3]->getText());



    }

    public function testGenerateLingualPairs()
    {

        $srtFile1 = new \SrtParser\srtFile(dirname(__FILE__) . '/../data/subtitles_utf8.synced.ru.srt');
        $srtFile2 = new \SrtParser\srtFile(dirname(__FILE__) . '/../data/subtitles.synced.en.srt');

        $tmpArr1 = [];
        foreach($srtFile1->getSubs() as $sub)
        {
            /**
             * @var $sub srtFileEntry
             */


            $tmpArr1[] = [
                'time'=>$sub->getStart(),
                'file'=>1,
                'sub'=> $sub
            ];
        }
        $tmpArr2 = [];

        foreach($srtFile2->getSubs() as $sub)
        {
            /**
             * @var $sub srtFileEntry
             */

            $tmpArr2[] = [
                'time'=>$sub->getStart(),
                'file'=>2,
                'sub'=>$sub

            ];

        }


        $mergedArr = Utils::array_orderBy(array_merge($tmpArr1, $tmpArr2),'time', SORT_ASC);

        $this->assertEquals(4, count($mergedArr));

        $this->assertEquals(1, $mergedArr[0]['file']);
        $this->assertEquals(2, $mergedArr[1]['file']);

        $this->assertEquals("Ну и как там?", $mergedArr[0]['sub']->getText());
        $this->assertEquals("- How's that going?", $mergedArr[1]['sub']->getText());

//        \Codeception\Util\Debug::debug($mergedArr);


        /**
         *  Merging and sorting
         */

        $groupedResultSubTitles = [];
        $groupedResultSubTitles[] = [
            'start' => $mergedArr[0]['sub']->getStart(),
            'stop' => $mergedArr[0]['sub']->getStop(),
            'records' => [$mergedArr[0]]
        ];

        /* @var $lastGroup srtFileEntry  */

        for($i=1; $i<count($mergedArr); $i++)
        {
            $sub = $mergedArr[$i]['sub'];

            end($groupedResultSubTitles);
            $lastGroup = &$groupedResultSubTitles[key($groupedResultSubTitles)];
            /* @var $sub srtFileEntry  */


            $calculatedStart = min($lastGroup['start'], $sub->getStart());
            $calculatedStop = max($lastGroup['stop'], $sub->getStop());
            $calculatedDiff = $calculatedStop - $calculatedStart;




            if($calculatedDiff <  ($sub->getStop() - $sub->getStart() + $lastGroup['stop'] - $lastGroup['start'])) {

                $lastGroup['records'][] = $mergedArr[$i];
                $lastGroup['start'] = $calculatedStart;
                $lastGroup['stop'] = $calculatedStop;

            } else {

                $groupedResultSubTitles[] = [
                    'start' => $mergedArr[$i]['sub']->getStart(),
                    'stop' => $mergedArr[$i]['sub']->getStop(),
                    'records' => [$mergedArr[$i]]
                ];

            }

        }
        \Codeception\Util\Debug::debug($groupedResultSubTitles);
        $this->assertEquals(2,count($groupedResultSubTitles));
        /**
         * filtering file column
         */

        $resultArray = [];
        foreach($groupedResultSubTitles as $groupKey => $group){

            if (is_array($group['records'])){


                foreach ($group['records'] as $record){

                    if(isset($resultArray[$groupKey][$record['file']]))
                        $resultArray[$groupKey][$record['file']] .= $record['sub']->getText();
                    else
                        $resultArray[$groupKey][$record['file']] = $record['sub']->getText();

                }

            }

        }

        \Codeception\Util\Debug::debug($resultArray);


    }




}



