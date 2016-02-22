<?php
namespace Kirugan\Advertstar;


abstract class AbstractRequest
{
    protected $data;

    public function getData()
    {
        return $this->data;
    }

    abstract function getName();
}