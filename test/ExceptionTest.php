<?php

namespace Test;

use PHPUnit\Framework\TestCase;

use Bdt\DictTransformer\DictTransformer;

use Bdt\DictTransformer\Resources\Item;

use Test\Entities\MissingGetIdTile;
use Test\Entities\Tile;

use Test\Transformers\FieldTransformer;
use Test\Transformers\Exceptions\MissingIncludeTransformer;
use Test\Transformers\Exceptions\MissingTransformTransformer;
use Test\Transformers\Exceptions\MissingGetIdTransformer;
use Test\Transformers\Exceptions\InvalidIdTransformer;

class ExceptionTest extends TestCase
{

    /**
     * @expectedException \Bdt\DictTransformer\Exceptions\MissingTransformException
     */
    public function testMissingTransform()
    {
        $tile = new Tile(1, 1, 2);

        (new DictTransformer)->transform(new Item($tile, new MissingTransformTransformer));
    }

    /**
     * @expectedException \Bdt\DictTransformer\Exceptions\MissingIncludeException
     */
    public function testMissingInclude()
    {
        $tile = new Tile(1, 1, 2);

        (new DictTransformer)->transform(new Item($tile, new MissingIncludeTransformer), ['missing']);
    }

    /**
     * @expectedException \Bdt\DictTransformer\Exceptions\MissingGetIdException
     */
    public function testMissingGetId()
    {
        $tile = new MissingGetIdTile(1, 2);

        (new DictTransformer)->transform(new Item($tile, new MissingGetIdTransformer));
    }
    
    /**
     * @expectedException \Bdt\DictTransformer\Exceptions\InvalidResourceException
     */
    public function testInvalidResource()
    {
        (new DictTransformer)->transform(new InvalidResource([], new FieldTransformer));
    }

    /**
     * @expectedException \Bdt\DictTransformer\Exceptions\InvalidIdException
     */
    public function testInvalidId()
    {
        (new DictTransformer)->transform(new Item([], new InvalidIdTransformer));
    }
}