<?php namespace Ctimt\SqlControl\Status;

use Ctimt\SqlControl\Status\Depreciated;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-09-12 at 15:08:21.
 */
class DepreciatedTest extends \CtimtTest\SqlControl\Mocks\TestStatus
{

    /**
     * @var Depreciated
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->configure(new Depreciated(), 'Depreciated', false, false);
    }
}
