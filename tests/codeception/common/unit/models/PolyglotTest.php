<?php
/**
 * @TODO move to backend tests
 */
namespace tests\codeception\common\unit\models;

use tests\codeception\common\unit\TestCase;
use Yii;
use pauko\billingual\models\Spanish;
use yii\base\Component;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;


class PolyglotTest extends TestCase
{

    use \Codeception\Specify;




    public function testSpanish()
    {

        $this->assertEquals(Spanish::find('preguntar')['root'], 'pregunt');



    }


}

