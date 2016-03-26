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
        $client = new Client();
        //$client->post(['']);
        //\Codeception\Util\Debug::debug($response);


    }




}

