<?php

namespace Test;

use DictTransformer\Resources\NullableItem;
use PHPUnit\Framework\TestCase;

use DictTransformer\DictTransformer;

use DictTransformer\Resources\Collection;

use Test\Entities\Field;
use Test\Entities\Tile;
use Test\Entities\Settlement;
use Test\Entities\Settlement2;

use Test\Transformers\TileTransformer;
use Test\Transformers\FieldTransformer;

class BulkTest extends TestCase
{
    public function testBulk()
    {
        $fields = [];
        for ($i=0; $i < 100; $i++) {
            $settlement = new Settlement($i, "foo");
            $field = new Field($i, mt_rand(0, 100000), $settlement);
            $fields[] = $field;
            $fields[] = $field;
        }
        
        $tiles = [];
        for ($i=0; $i < 100; $i++) {
            $tile = new Tile($i, mt_rand(0, 100), mt_rand(0, 100), $fields);
            $tiles[] = $tile;
            $tiles[] = $tile;
        }

        $data = (new DictTransformer)->transform(new Collection($tiles, new TileTransformer), [
            'fields.settlement',
        ]);
    
        $this->assertTrue(true);
    }
}