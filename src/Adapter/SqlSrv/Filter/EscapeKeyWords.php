<?php namespace Ctimt\SqlControl\Adapter\SqlSrv\Filter;

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
        $this->_keyWords = $keyWords;
        return $this;
    }

    public function filter($value) {
        foreach ($this->_keyWords as $keyword) {
            $pattern = sprintf('/[\s\(](%s)(?:\s|\.|$)/i',$keyword);
            $value = preg_replace_callback($pattern, function($matches){
                $replace = '[' . $matches[1] . ']';
                return str_replace($matches[1], $replace, $matches[0]);
            }, $value);
                
        }
        return $value;
    }

}
