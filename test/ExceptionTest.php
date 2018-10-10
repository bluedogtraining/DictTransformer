<?php

namespace Test;

use PHPUnit\Framework\TestCase;

use DictTransformer\DictTransformer;

use DictTransformer\Resources\Item;

use Test\Entities\MissingGetIdTile;
use Test\Entities\Tile;

use Test\Transformers\Exceptions\MissingIncludeTransformer;
use Test\Transformers\Exceptions\MissingTransformTransformer;
use Test\Transformers\Exceptions\MissingGetIdTransformer;

class ExceptionTest extends TestCase
{

    /**
     * @expectedException \DictTransformer\Exceptions\MissingTransformException
     */
    public function testMissingTransform()
    {
        $tile = new Tile(1, 1, 2);

        (new DictTransformer)->transform(new Item($tile, new MissingTransformTransformer));
    }

    /**
     * @expectedException \DictTransformer\Exceptions\MissingIncludeException
     */
    public function testMissingInclude()
    {
        $tile = new Tile(1, 1, 2);

        (new DictTransformer)->transform(new Item($tile, new MissingIncludeTransformer), ['missing']);
    }

    /**
     * @expectedException \DictTransformer\Exceptions\MissingGetIdException
     */
    public function testMissingGetId()
    {
        $tile = new MissingGetIdTile(1, 2);

        (new DictTransformer)->transform(new Item($tile, new MissingGetIdTransformer));
    }
}