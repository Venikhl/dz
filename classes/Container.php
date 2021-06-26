<?php

require_once __DIR__ . '/BaseTag.php';

final class Container extends BaseTag
{
    public function __construct(array $attrs = [])
    {
        parent::__construct('section', $attrs);
        $this->attr('class', 'container');
    }
}