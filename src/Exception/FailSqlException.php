<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ctimt\SqlControl\Exception;

/**
 * Description of FailSqlException
 *
 * @author David
 */
class FailSqlException extends \Exception{
    
    private $sql;
    
    public function __construct($message = "", $code = 0, $previous = null, $sql = null) {
        parent::__construct($message, $code, $previous);
        $this->setSql($sql);
    }
    
    public function getSql() {
        return $this->sql;
    }

    public function setSql($sql) {
        $this->sql = $sql;
        return $this;
    }

}
