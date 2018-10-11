<?php

namespace Test\Transformers;

use Test\Entities\Settlement;
use DictTransformer\TransformerInterface;

class SettlementTransformer implements TransformerInterface
{
    public function getKey()
    {
        return 'settlements';
    }

    public function getIdField()
    {
        return 'id';
    }

    public function getId($entity)
    {
        return $entity->getId();
    }

    /**
     * @param Settlement $settlement
     *
     * @return array
     */
    public function transform(Settlement $settlement) : array
    {
        return [
            'id'   => $settlement->getId(),
            'name' => $settlement->getName(),
        ];
    }
}