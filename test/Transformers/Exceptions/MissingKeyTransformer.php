<?php

namespace Test\Transformers\Exceptions;

use DictTransformer\TransformerInterface;

/**
 * @package App\Transformers
 */
class MissingKeyTransformer implements TransformerInterface
{

    public function transform($data)
    {
        return [
            'id' => $data->getId(),
        ];
    }
}