<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

use Ctimt\SqlControl\Adapter\FilterInterface;

/**
 * Description of EscapeKeyWords
 *
 * @author David
 */
class EscapeKeyWords implements FilterInterface {

    private $_keyWords = [];

    public function __construct(array $keyWords) {
        $this->setKeyWords($keyWords);
    }

    public function getKeyWords() {
        return $this->_keyWords;
    }

    public function setKeyWords(array $keyWords) {
        $final = [];
        foreach ($keyWords as $keyWord) {
            $final[" $keyWord "] = ' [' . $keyWord . '] ';
        }
        $this->_keyWords = $final;
        return $this;
    }

    public function filter($value) {
        return strtr($value, $this->getKeyWords());
    }

}
