<?php

namespace Test\Transformers;

use DictTransformer\Resources\Collection;
use Test\Entities\Tile;
use DictTransformer\TransformerInterface;

/**
 * @package App\Transformers
 */
class TileTransformer implements TransformerInterface
{

    const KEY = 'tiles';

    /**
     * @param Tile $tile
     *
     * @return array
     */
    public function transform(Tile $tile) : array
    {
        return [
            'id' => $tile->getId(),
            'x'  => $tile->getX(),
            'y'  => $tile->getY(),
        ];
    }

    /**
     * @param Tile $tile
     *
     * @return Collection
     */
    public function fields(Tile $tile) : Collection
    {
        $fields = $tile->getFields();

        return new Collection($fields, new FieldTransformer);
    }
}