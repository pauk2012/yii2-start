<?php
/**
 * @TODO move to backend tests
 */
namespace tests\codeception\common\unit\models;

use Yii;
use tests\codeception\common\fixtures\UserFixture;
use tests\codeception\common\unit\DbTestCase;
use tests\codeception\common\fixtures\TaxonomyFixture;
use pauko\taxonomy\models\Taxonomy;
use vova07\users\models\User;
use yii\base\Component;
use yii\base\NotSupportedException;
use yii\rbac\PhpManager;
use yii\web\IdentityInterface;


class TaxonomyTest extends DbTestCase
{

    use \Codeception\Specify;

    public function setUp()
    {
        $this->markTestSkipped('must be revisited');

    }


    public function fixtures()
    {
        return [
            'taxonomies' => TaxonomyFixture::className(),
            'users' => UserFixture::className(),
        ];
    }


    public function testTaxonomy()
    {
        /*
        $appConfig = [
            'components' => [
                'user' => [
                    'identityClass' => UserIdentity::className(),
                    'authTimeout' => 10,
                ],
            ],
        ];
        $this->mockWebApplication($appConfig);
        Yii::$app->user->login(User::findIdentity('user1'));
        */

        $application = $this->mockApplication();

        $application->runtimePath = '@tests/codeception/common/runtime';

        $user = User::findByUsername('bayer.hudson');
        $newRoot = new Taxonomy;
        $newRoot->attributes = ['name' => 'Гео', 'alias' => 'geo', 'created_by' => $user->id];
        //$newRoot->validate();
        $this->assertTrue($newRoot->saveNode(false));

        $this->assertEquals($newRoot->taxonomy_id, $newRoot->id);
        $this->assertEquals($newRoot->path, $newRoot->id);
        $this->assertInstanceOf(Taxonomy::className(),Taxonomy::find()->where(['name' => 'Гео', 'alias' => 'geo'])->one());
        $geoItem = new Taxonomy;
        $geoItem->attributes = ['name' => 'ГЕО 1', 'alias' => 'geo1', 'created_by' => $user->id];
        //$geoItem->validate();
        $this->assertTrue($geoItem->appendTo($newRoot, false));
        $this->assertEquals($newRoot->path . '.' . $geoItem->id, $geoItem->path);
        $this->assertEquals($geoItem->taxonomy_id, $newRoot->id);
        //$geoItem->delete();
        $foundedGeoItem = Taxonomy::findOne($geoItem->id);
        $this->assertInstanceOf(Taxonomy::className(),$foundedGeoItem);
        $this->assertEquals($newRoot->path . '.' . $foundedGeoItem->id, $foundedGeoItem->path);

       // $structure = Taxonomy::getStructure('alias');
       // \Codeception\Util\Debug::debug($structure);
        $result = Taxonomy::findByPath($newRoot->path, 'alias');
        \Codeception\Util\Debug::debug($result);

        $this->assertInstanceOf(Taxonomy::className(),Taxonomy::findByPath('geo', 'alias'));
        $this->assertEquals($newRoot->id, Taxonomy::findByPath('geo', 'alias')->id);
        $this->assertInstanceOf(Taxonomy::className(),Taxonomy::findByPath('geo/geo1', 'alias'));
        $this->assertEquals($geoItem->id, Taxonomy::findByPath('geo/geo1', 'alias')->id);
        $this->assertEquals($geoItem->id, Taxonomy::findByPath('Гео/Гео 1')->id);

    }
    public function _testTaxonomy()
    {
       // $model = $this->mockTag(new Tag);
        $taxonomy = new Taxonomy;
        $test = $taxonomy->name;
        $name['en'] = 'testtaxonomy';
        $taxonomy->name = $name;
        $this->assertTrue($taxonomy->save(false));

        $roots = Taxonomy::find()->roots()->all();
        $this->assertEquals(0, count($roots));
        $root1 = Taxonomy::createRoot(['en' => 'root1']);
        $roots = Taxonomy::find()->roots()->all();
        $this->assertEquals(1, count($roots));
        $this->assertTrue($root1 instanceof Taxonomy);

        $existedRoot1 = Taxonomy::createRoot(['en' => 'root1'], true);
        //$this->assertEquals($root1->id, $existedRoot1->id);

        $root1Taxonomy1 = Taxonomy::createChild(['en' => 'root1_taxonomy1'], $root1);
        $this->assertTrue($root1Taxonomy1 instanceof Taxonomy);

        $existedTaxonomy = Taxonomy::createChild(['en' => 'root1_taxonomy1'], $root1, true);
        $this->assertEquals($root1Taxonomy1->id, $existedTaxonomy->id);

        $anotherTaxonomy = Taxonomy::createChild(['en' => 'root_taxonomy1'], $root1, true);
        $this->assertNotEquals($root1Taxonomy1->id, $anotherTaxonomy->id);
        //select * from mk3u_taxonomy WHERE path <@ '2' AND path ~ '2.*{1}' AND name::hstore->'en' = 'root1_taxonomy1';





        //new \common\modules\geo\models\query\TaxonomyQuery;
        $root2 = Taxonomy::createRoot(['en' => 'root2']);
        $root2Taxonomy1 = Taxonomy::createChild(['en' => 'root2_taxonomy1'], $root2);

        $taxonomy = Taxonomy::findByPath('root2.root2_taxonomy1');
        $this->assertTrue($taxonomy instanceof Taxonomy);

        $this->assertEquals(2,count(Taxonomy::getRoots()));






    }

/*
    private function mockTag($tag)
    {
        $tag = $this->getMock('common\modules\geo\models\Tag');
        //$loginForm->expects($this->any())->method('getUser')->will($this->returnValue($tag));
        return $tag;
    }
*/

}

class UserIdentity extends Component implements IdentityInterface
{
    private static $ids = [
        'user1',
        'user2',
        'user3',
    ];
    private $_id;
    public static function findIdentity($id)
    {
        if (in_array($id, static::$ids)) {
            $identitiy = new static();
            $identitiy->_id = $id;
            return $identitiy;
        }
    }
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException();
    }
    public function getId()
    {
        return $this->_id;
    }
    public function getAuthKey()
    {
        throw new NotSupportedException;
    }
    public function validateAuthKey($authKey)
    {
        throw new NotSupportedException();
    }
}
