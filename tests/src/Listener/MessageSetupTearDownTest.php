<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ctimt\SqlControl\Listener;

use PHPUnit_Framework_TestCase;

/**
 * Description of MessageSetupTearDownTest
 *
 * @author David
 */
class MessageSetupTearDownTest extends PHPUnit_Framework_TestCase{
    protected $object;
    
    protected function setUp() {
        $this->object = new MessageSetupTearDown();
    }
    
    
}
