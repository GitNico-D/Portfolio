<?php

namespace App\Hateoas;

class Link
{
    /**
     * @var string
     */
    public $action;

    /**
     * @var string
     */
    public $route;

    /**
     */
    public function __construct(string $action, string $href)
    {
        $this->rel = $action;
        $this->href = $href;
    }

    public function getHref(): string
    {
        return $this->href;
    }

    public function getAction(): string
    {
        return $this->action;
    }
}