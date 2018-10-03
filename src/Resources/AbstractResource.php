<?php

namespace DictTransformer\Resources;

class AbstractResource implements ResourceInterface
{
    protected $data;
    protected $transformer;

    public function __construct($data, $transformer)
    {
        $this->data = $data;
        $this->transformer = $transformer;
    }

    public function getTransformer()
    {
        return $this->transformer;
    }

    public function getData()
    {
        return $this->data;
    }

}