<?php

namespace Test\Transformers\Exceptions;

use DictTransformer\TransformerInterface;

/**
 * @package App\Transformers
 */
class MissingGetIdTransformer implements TransformerInterface
{

    const KEY = 'fields';

    public function transform($data)
    {
        return [
            'id' => $data->getId(),
        ];
    }
}