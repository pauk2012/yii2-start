<?php
/**
 * @TODO move to backend tests
 */
namespace tests\codeception\common\unit\models;


use pauko\billingual\models\SpanishConjugation;
use pauko\billingual\models\SpanishInfinitive;
use tests\codeception\common\fixtures\SpanishConjugationFixture;
use tests\codeception\common\fixtures\SpanishInfinitiveFixture;
use tests\codeception\common\fixtures\UserFixture;
use Yii;

use tests\codeception\common\unit\DbTestCase;


use yii\base\Component;
use yii\base\NotSupportedException;
use yii\rbac\PhpManager;
use yii\web\IdentityInterface;


class SpanishConjugationTest extends DbTestCase
{

    use \Codeception\Specify;




    public function fixtures()
    {
        return [
            'users' => UserFixture::className(),
            'spanish_infinitives' => SpanishInfinitiveFixture::className(),
            'spanish_conjugations' => SpanishConjugationFixture::className(),



        ];
    }

    public function testResolveIsRegular()
    {
        $infinitive =  $this->spanish_infinitives('trabajar');
        $conjugations = $infinitive->getConjugations()->all();

        // remove last 2 charackter . suppose that regullar
        $root = substr($infinitive, 0, strlen($infinitive)-2);
        $suffix = substr($infinitive,  -2);
        $this->assertEquals('ar', $suffix);
        $this->assertEquals('trabaj', $root);

        $suffixRules = SpanishInfinitive::$regularSuffixes['ar'];

        foreach ($conjugations as $conjugation)
        {
            $expected = $root . $suffixRules[$conjugation->form_id];

            $this->assertEquals($expected,$conjugation);

        }

        $infinitive =  $this->spanish_infinitives('trabajar');
        $this->assertTrue($infinitive->resolveIsRegular());
        $this->assertEquals(1,(integer) $infinitive->resolveIsRegular());


        $infinitive =  $this->spanish_infinitives('ir');
        $this->assertEquals(0,(integer) $infinitive->resolveIsRegular());





    }

    public function testFixtures()
    {
        $infinitive = $this->spanish_infinitives('trabajar');
        //codecept_debug(SpanishInfinitive::find()->where(['infinitive' => (string)$infinitive])->one());
        $this->assertEquals(null,SpanishInfinitive::find()->where(['infinitive' => 'ber'])->one());
    }


}
