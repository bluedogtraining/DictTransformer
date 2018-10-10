<?php

namespace Test\Transformers\Exceptions;

use DictTransformer\TransformerInterface;

/**
 * @package App\Transformers
 */
class MissingGetIdTransformer implements TransformerInterface
{
    public function getKey()
    {
        return 'fields';
    }

    public function transform($data)
    {
        return [
            'id' => $data->getId(),
        ];
    }
}