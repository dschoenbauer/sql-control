<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ctimt\SqlControl\Framework;

/**
 * Description of SqlChangeAwareInterface
 *
 * @author David
 */
interface SqlChangeAwareInterface {
    public function setSqlChange(SqlChange $sqlChange);
}
