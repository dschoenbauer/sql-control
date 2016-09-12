<?php
/*
 * Copyright (c) 2016, David Schoenbauer <dschoenbauer@gmail.com>
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 *     - Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *
 *     - Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *
 *     - Neither the name of David Schoenbauer, Dschoenbauer nor the names of its 
 *       contributors may be used to endorse or promote products derived
 *       from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR
 * ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */
namespace DschoenbauerTest\SqlControl\Status;

use Dschoenbauer\SqlControl\Status\StatusInterface;
use PHPUnit_Framework_TestCase;

/**
 * Description of TestStatus
 *
 * @author Bruce Schubert
 */
class TestStatus extends PHPUnit_Framework_TestCase
{

    private $_testStatus;
    private $_testName;
    private $_testIsLoaded;
    private $_testIspendingLoad;

    public function configure(StatusInterface $status, $name, $isLoaded, $isPendingLoad)
    {
        $this->setTestStatus($status)->setTestName($name)->setTestIsLoaded($isLoaded)->setTestIsPendingLoad($isPendingLoad);
    }

    public function testName()
    {
        $this->assertEquals($this->getTestName(), $this->getTestStatus()->getName());
    }

    public function testIsLoaded()
    {
        $this->assertEquals($this->getTestIsLoaded(), $this->getTestStatus()->IsLoaded());
    }

    public function testIsPendingLoad()
    {
        $this->assertEquals($this->getTestIspendingLoad(), $this->getTestStatus()->isPendingLoad());
    }

    /**
     * @return StatusInterface
     */
    public function getTestStatus()
    {
        return $this->_testStatus;
    }

    public function getTestName()
    {
        return $this->_testName;
    }

    public function getTestIsLoaded()
    {
        return $this->_testIsLoaded;
    }

    public function getTestIspendingLoad()
    {
        return $this->_testIspendingLoad;
    }

    public function setTestStatus($testStatus)
    {
        $this->_testStatus = $testStatus;
        return $this;
    }

    public function setTestName($testName)
    {
        $this->_testName = $testName;
        return $this;
    }

    public function setTestIsLoaded($testIsLoaded)
    {
        $this->_testIsLoaded = $testIsLoaded;
        return $this;
    }

    public function setTestIspendingLoad($testIspendingLoad)
    {
        $this->_testIspendingLoad = $testIspendingLoad;
        return $this;
    }
}
