<?php

namespace Test\Transformers\Exceptions;

use DictTransformer\TransformerInterface;

/**
 * @package App\Transformers
 */
class MissingIncludeTransformer implements TransformerInterface
{

    const KEY = 'tiles';

    public function transform($data)
    {
        return [
            'id' => $data->getId(),
        ];
    }
}