<?php

namespace Test\Transformers\Exceptions;

use Bdt\DictTransformer\TransformerInterface;

class MissingGetIdTransformer implements TransformerInterface
{
    public function getKey()
    {
        return 'fields';
    }

    public function getIdField()
    {
        return 'id';
    }

    public function transform($data)
    {
        return [
            'id' => $data->getId(),
        ];
    }
}
