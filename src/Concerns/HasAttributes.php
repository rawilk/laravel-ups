<?php

namespace Rawilk\Ups\Concerns;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Rawilk\Ups\Entity\Entity;

trait HasAttributes
{
    /*
     * A mapping of keys to use instead of the ones provided by
     * an xml object returned from the API.
     */
    protected array $attributeKeyMap = [];

    /*
     * In the UPS API some fields are sent in the XML as an "Indicator" empty
     * field, which gets converted to an empty array in fromXml(). In those
     * cases we want that value to show up as true instead of false.
     */
    protected bool $castEmptyArraysAsTrue = true;

    public function convertPropertyNamesToSnakeCase(array $data, string $parentKey = null): array
    {
        $properties = [];

        foreach ($data as $key => $value) {
            if (! is_numeric($key)) {
                $key = $this->studlyToSnake($key);
            }

            // Used if we have an array of relationships.
            $originalKey = $key;

            if ($this->hasRelationship($relationship = Str::camel((string) $key))) {
                if (! $value instanceof Entity) {
                    $value = $this->createRelationshipFromArray($relationship, $value, (string) $key);
                }

                if (is_array($value)) {
                    // We have an array of the related entity, remove the key for now.
                    $originalKey = $key;
                    $key = null;
                }
            }

            if (is_array($value) && ! is_null($key)) {
                $value = $this->convertPropertyNamesToSnakeCase($value, (string) $key);
            }

            if ($this->shouldFlattenArrayValue($value)) {
                $value = Arr::flatten($value);
            }

            if (is_null($key) && ! $this->hasRelationshipParentKeyMapped((string) $parentKey, (string) $originalKey)) {
                $key = $originalKey;
            }

            $properties[$key] = $value;
        }

        return $properties;
    }

    protected function studlyToSnake(string $studlyCase): string
    {
        $pattern = '~[^A-Z]+\K|(?=[A-Z][^A-Z]+)~';

        return collect(preg_split($pattern, $studlyCase, -1, PREG_SPLIT_NO_EMPTY))
            ->map(fn (string $word) => strtolower($word))
            ->implode('_');
    }

    protected function shouldFlattenArrayValue($value): bool
    {
        return is_array($value)
            && count($value) === 1
            && array_keys($value)[0] === '';
    }
}
