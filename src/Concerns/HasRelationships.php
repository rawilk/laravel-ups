<?php

namespace Rawilk\Ups\Concerns;

use function get_parent_class;

trait HasRelationships
{
    /*
     * Any keys in this array will have their keys stripped when attributes
     * are filled on the entity and they are inside of a "container"
     * element.
     */
    protected array $relationshipParentKeyMap = [];

    public function hasRelationship(string $relationship): bool
    {
        return method_exists($this, $relationship);
    }

    public function relationResolver($class, $key)
    {
        if ($resolver = static::$relationResolvers[$class][$key] ?? null) {
            return $resolver;
        }

        if ($parent = get_parent_class($class)) {
            return $this->relationResolver($parent, $key);
        }

        return null;
    }

    protected function createRelationshipFromArray(string $relationship, array $data, string $parentKey = null)
    {
        // If we have a non-associative array, we probably have an array of related entities.
        if (! $this->isAssociativeArray($data)) {
            $related = [];

            foreach ($data as $relationData) {
                $related[] = $this->createRelationshipFromArray($relationship, $relationData, $parentKey);
            }

            return $related;
        }

        $relatedClass = $this->$relationship();

        /** @var \Rawilk\Ups\Entity\Entity $related */
        $related = new $relatedClass;

        return $related->fill(
            $related->convertPropertyNamesToSnakeCase($data, $parentKey)
        );
    }

    protected function hasRelationshipParentKeyMapped(string $parentKey, string $key): bool
    {
        return array_key_exists($parentKey, $this->relationshipParentKeyMap)
            && $this->relationshipParentKeyMap[$parentKey] === $key;
    }

    protected function isAssociativeArray(array $array): bool
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }
}
