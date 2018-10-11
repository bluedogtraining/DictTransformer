<?php

namespace Test\Transformers\Exceptions;

use DictTransformer\TransformerInterface;

/**
 * @package App\Transformers
 */
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