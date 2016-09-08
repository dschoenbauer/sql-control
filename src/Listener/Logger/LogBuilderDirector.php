<?php
namespace Dschoenbauer\SqlControl\Listener\Logger;

/**
 * Description of LogBuilderDirector
 *
 * @author David Schoenbauer <dschoenbauer@gmail.com>
 */
class LogBuilderDirector
{
    
    private $builder;

    public function __construct(LogBuilderInterface $builder)
    {
        $this->setBuilder($builder);
    }

    public function buildLogger(){
        return $this->getBuilder()->buildLogger();
    }


    /**
     * @return LogBuilderInterface
     */
    public function getBuilder()
    {
        return $this->builder;
    }

    public function setBuilder($builder)
    {
        $this->builder = $builder;
        return $this;
    }
}
