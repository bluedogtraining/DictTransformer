<?php

namespace Test\Transformers\Exceptions;

use Bdt\DictTransformer\TransformerInterface;

class MissingTransformTransformer implements TransformerInterface
{
    public function getKey()
    {
        return 'fields';
    }

    public function getIdField()
    {
        return 'id';
    }

    public function getId($entity)
    {
        return $entity->getId();
    }
}
