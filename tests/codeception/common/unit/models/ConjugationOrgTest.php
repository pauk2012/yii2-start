<?php
/**
 * @TODO move to backend tests
 */
namespace tests\codeception\common\unit\models;


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


class DiffTest extends TestCase
{

    use \Codeception\Specify;




    public function testDiff()
    {

       // $this->assertEquals(Spanish::find('preguntar')['root'], 'pregunt');

        $diff = new Diff(['tomar'], ['tomamos']);



        \Codeception\Util\Debug::debug($diff->render(new ArrayRenderer()));

    }

    public function testSoundEx()
    {

        \Codeception\Util\Debug::debug(soundex('announce'));
        \Codeception\Util\Debug::debug(soundex('anunciar'));
        \Codeception\Util\Debug::debug(soundex('celebrate'));
        \Codeception\Util\Debug::debug(soundex('celebrar'));
    }


}

