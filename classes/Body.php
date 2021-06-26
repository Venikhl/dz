<?php

require_once __DIR__ . '/BaseTag.php';

class Body
{
    protected $parent;
    protected $body = [];

    public function __construct(BaseTag $parent)
    {
        $this->parent = $parent;
    }

    function parent(){
        return $this->parent;
    }

    function get(): array{
        return $this->body;
    }

    function set($value){
        if($this->parent()->isSelfClosing())
            throw new LogicException("Tag is self closing");

        if(!is_array($value))
            $value = [$value];

        $this->body = $value;
        return $this;
    }

    function append($value){
        $old = $this->get();
        $old[] = $value;
        return $this->set($old);
    }

    function prepend($value){
        $old = $this->get();
        array_unshift($old, $value);
        return $this->set($old);
    }

    public function __toString(): string
    {
        return implode($this->get());
    }
}