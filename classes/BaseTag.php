<?php
// ctrl + alt + t

require_once __DIR__.'/Name.php';
require_once __DIR__.'/Body.php';
require_once __DIR__.'/Attributes.php';

abstract class BaseTag
{
    protected $name;
    protected $attributes;
    protected $body;

    public function __construct(string $name, array $attrs = [])
    {
        $this->name = new Name($name);
        $this->attributes = new Attributes($attrs);
        $this->body = new Body($this);
    }

    //region NAME
    function name(){
        return $this->name;
    }

    function isSelfClosing(){
        return $this->name()->isSelfClosing();
    }
    //endregion

    //region ATTRIBUTES
    function attributes() {
        return $this->attributes;
    }
    //endregion

    //region BODY
    function body() {
        return $this->body;
    }

    function append($value) {
        $this->body()->append($value);
        return $this;
    }

    function prepend($value) {
        $this->body()->prepend($value);
        return $this;
    }
    //endregion

    function appendTo(BaseTag $tag){
        $tag->append($this);
        return $this;
    }

    function prependTo(BaseTag $tag){
        $tag->prepend($this);
        return $this;
    }

    function attr(string $key, $value = null) {
        $this->attributes()->set($key, $value);
        return $this;
    }

    public function __call(string $name, array $arguments)
    {
        return $this->attr($name, ...$arguments);
    }

    public function __get(string $name)
    {
        return $this->attributes()->get($name);
    }

    public function __set(string $name, $value)
    {
        $this->attr($name, $value);
    }

    function toString(): string{
        $name = $this->name();
        $attrs = $this->attributes();
        $body = $this->body();

        $tag = "<{$name}{$attrs}";

        if($this->isSelfClosing())
            return "$tag />";

        return "{$tag}>{$body}</{$name}>";
    }

    function __toString(): string{
        return $this->toString();
    }

    //___________

}