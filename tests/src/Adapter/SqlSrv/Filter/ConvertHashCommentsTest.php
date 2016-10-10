<?php namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

/**
 * Description of ConvertHashCommentsTest
 *
 * @author David
 */
class ConvertHashCommentsTest extends \PHPUnit_Framework_TestCase {
    /* @var $pbject ConvertHashComments */

    private $object;

    protected function setUp() {
        $this->object = new ConvertHashComments();
    }

    public function testFilter() {
        $test = "#commented out
next line";
        $result = "/*commented out*/
next line";
        $this->assertEquals($result, $this->object->filter($test));
    }

}
