<?php

namespace DictTransformer;

use DictTransformer\Exceptions\InvalidIdException;
use DictTransformer\Exceptions\InvalidResourceException;
use DictTransformer\Exceptions\MissingTransformException;
use DictTransformer\Exceptions\MissingKeyException;
use DictTransformer\Exceptions\MissingIncludeException;
use DictTransformer\Exceptions\MissingGetIdException;

use DictTransformer\Resources\Collection;
use DictTransformer\Resources\Item;
use DictTransformer\Resources\NullableItem;
use DictTransformer\Resources\ResourceInterface;

/**
 * @package DictTransformer
 */
class DictTransformer
{

    /**
     * @var array
     */
    private $entities = [];

    /**
     * @var array
     */
    private $cache = [];

    /**
     * @param ResourceInterface $resource
     * @param array             $includes
     *
     * @return array
     * @throws InvalidResourceException
     */
    public function transform(ResourceInterface $resource, array $includes = [])
    {
        $keys = $this->transformResource($resource, $includes);

        $entities = $this->entities;
        $this->entities = [];
        $this->cache = [];

        return [
            'result'   => $keys,
            'entities' => $entities,
        ];
    }

    /**
     * @param ResourceInterface $resource
     * @param array             $includes
     *
     * @return array
     * @throws InvalidResourceException
     */
    private function transformResource($resource, array $includes = [])
    {
        switch (true) {

            case $resource instanceof Item:

                return $this->transformItem($resource, $includes);

            case $resource instanceof Collection:

                return $this->transformCollection($resource, $includes);

            case $resource instanceof NullableItem:

                return $this->transformNullableItem($resource, $includes);

            default:

                throw new InvalidResourceException;
        }
    }

    /**
     * @param Item  $item
     * @param array $includes
     *
     * @return mixed
     * @throws MissingGetIdException
     * @throws MissingIncludeException
     * @throws MissingKeyException
     * @throws MissingTransformException
     */
    private function transformItem(Item $item, array $includes = [])
    {
        $entity = $item->getData();
        $transformer = $item->getTransformer();

        $key = $this->transformEntity($entity, $transformer, $includes);

        return $key;
    }

    private function transformNullableItem(NullableItem $item, array $includes = [])
    {
        $entity = $item->getData();
        $transformer = $item->getTransformer();

        $key = $key = $this->transformEntity($entity, $transformer, $includes, true);

        return $key;
    }

    /**
     * @param Collection $collection
     * @param array      $includes
     *
     * @return array
     * @throws MissingGetIdException
     * @throws MissingIncludeException
     * @throws MissingKeyException
     * @throws MissingTransformException
     */
    private function transformCollection(Collection $collection, array $includes = [])
    {
        $entities = $collection->getData();
        $transformer = $collection->getTransformer();

        $keys = [];

        foreach ($entities as $entity) {

            $key = $this->transformEntity($entity, $transformer, $includes);

            $keys[] = $key;
        }

        return $keys;
    }

    /**
     * @param       $entity
     * @param       $transformer
     * @param array $includes
     * @param bool  $nullable
     *
     * @return mixed
     * @throws MissingIncludeException
     * @throws MissingKeyException
     * @throws MissingTransformException
     * @throws InvalidResourceException
     * @throws MissingGetIdException
     */
    private function transformEntity($entity, $transformer, array $includes = [], $nullable = false)
    {
        if (!method_exists($transformer, 'transform')) {
            throw new MissingTransformException;
        }

        if (!$this->hasKeyConstant($transformer)) {
            throw new MissingKeyException;
        }

        if ($nullable && $entity == null) {
            return null;
        }

        if (!method_exists($entity, "getId")) {
            throw new MissingGetIdException();
        }

        $entityId = $entity->getId();

        if (isset($this->cache[$transformer::KEY][$entityId])) {
            $data = $this->cache[$transformer::KEY][$entityId];
        }
        else {
            $data = $transformer->transform($entity);

            $this->cache[$transformer::KEY][$entityId] = $data;
        }

        foreach ($includes as $include) {

            $parsedIncludeString = $this->parseIncludeString($include);

            $current = $parsedIncludeString['current'];
            $rest = $parsedIncludeString['rest'];

            if (!method_exists($transformer, $current)) {
                throw new MissingIncludeException(get_class($transformer), $current);
            }

            $resource = $transformer->{$current}($entity);

            $data[$current] = $this->transformResource($resource, $rest);
        }

        $idField = $this->getIdField($transformer);

        if (!isset($data[$idField])) {
            throw new InvalidIdException;
        }

        $this->entities[$transformer::KEY][$data[$idField]] = isset($this->entities[$transformer::KEY][$data[$idField]])
            ? array_merge($this->entities[$transformer::KEY][$data[$idField]], $data)
            : $data;

        return $data[$idField];
    }

    /**
     * @param string $includeString
     *
     * @return array
     */
    private function parseIncludeString(string $includeString)
    {
        $position = strpos($includeString, '.');

        if ($position !== false) {

            return [
                'current' => substr($includeString, 0, $position),
                'rest'    => [substr($includeString, $position + 1)],
            ];
        }

        return [
            'current' => $includeString,
            'rest'    => [],
        ];
    }

    /**
     * @param $transformer
     *
     * @return string
     */
    private function getIdField($transformer): string
    {
        $transformerName = get_class($transformer);
        return $this->hasIdConstant($transformer) ? $transformerName::ID : 'id';
    }

    /**
     * @param $transformer
     *
     * @return bool
     */
    private function hasIdConstant($transformer)
    {
        return $this->hasConstant($transformer, 'ID');
    }

    /**
     * @param $transformer
     *
     * @return bool
     */
    private function hasKeyConstant($transformer)
    {
        return $this->hasConstant($transformer, 'KEY');
    }

    /**
     * @param        $transformer
     * @param string $constant
     *
     * @return bool
     */
    private function hasConstant($transformer, string $constant)
    {
        $transformerName = get_class($transformer);
        return defined("$transformerName::$constant");
    }
}