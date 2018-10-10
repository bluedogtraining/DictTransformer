<?php

namespace Test\Transformers;

use Test\Entities\Settlement2;
use DictTransformer\TransformerInterface;

class Settlement2Transformer implements TransformerInterface
{

    const KEY = 'settlements2';

    /**
     * @param Settlement2 $settlement2
     *
     * @return array
     */
    public function transform(Settlement2 $settlement2) : array
    {
        return [
            'id'   => $settlement2->getId(),
            'name' => $settlement2->getName(),
        ];
    }
}