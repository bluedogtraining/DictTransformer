<?php

namespace Test\Transformers\Exceptions;

use Bdt\DictTransformer\TransformerInterface;

class InvalidIdTransformer implements TransformerInterface
{
    public function getIdField()
    {
        return 'id';
    }

    public function getKey()
    {
        return 'foo';
    }

    public function getId($entity)
    {
        return 1;
    }

    public function transform($entity)
    {
        return [
            'foo' => 'bar'
        ];
    }
}
