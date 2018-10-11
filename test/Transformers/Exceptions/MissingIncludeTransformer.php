<?php

namespace Test\Transformers\Exceptions;

use Bdt\DictTransformer\TransformerInterface;

class MissingIncludeTransformer implements TransformerInterface
{
    public function getKey()
    {
        return 'tiles';
    }

    public function getIdField()
    {
        return 'id';
    }

    public function getId($entity)
    {
        return $entity->getId();
    }

    public function transform($data)
    {
        return [
            'id' => $data->getId(),
        ];
    }
}