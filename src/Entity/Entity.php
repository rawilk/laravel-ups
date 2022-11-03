<?php

namespace Rawilk\Ups\Entity;

use ArrayAccess;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use Illuminate\Database\Eloquent\JsonEncodingException;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use JsonSerializable;
use Rawilk\Ups\Concerns\HasAttributes as EntityHasAttributes;
use Rawilk\Ups\Concerns\HasRelationships;
use Rawilk\Ups\Contracts\Xmlable;
use Rawilk\Ups\Support\Xml;
use SimpleXMLElement;

abstract class Entity implements ArrayAccess, Arrayable, Jsonable, JsonSerializable, Xmlable
{
    use EntityHasAttributes;
    use HasRelationships;
    use HasAttributes {
        setAttribute as hasAttributesSetAttribute;
        getAttribute as hasAttributesGetAttribute;
    }

    public $exists = false;

    public function __construct(array $attributes = [])
    {
        $this->boot();

        $this->fill($attributes);
    }

    public static function make(array $attributes = []): self
    {
        return new static($attributes);
    }

    protected function boot(): void
    {
        $this->attributes = [];

        $this->bootTraits();

        if (method_exists($this, 'booted')) {
            $this->booted();
        }
    }

    protected function bootTraits(): void
    {
        $class = static::class;

        $booted = [];

        foreach (class_uses_recursive($class) as $trait) {
            $method = 'boot' . class_basename($trait);

            if (method_exists($class, $method) && ! in_array($method, $booted, true)) {
                $this->$method();

                $booted[] = $method;
            }
        }
    }

    public function __get(string $key)
    {
        return $this->getAttribute($key);
    }

    public function __set(string $key, $value)
    {
        $this->setAttribute($key, $value);
    }

    public function __isset(string $key)
    {
        return isset($this->attributes[$key]);
    }

    public function __unset(string $key)
    {
        unset($this->attributes[$key]);
    }

    public function __toString(): string
    {
        return $this->toJson();
    }

    public function offsetExists($key): bool
    {
        return ! is_null($this->getAttribute($key));
    }

    public function offsetGet(mixed $key): mixed
    {
        return $this->getAttribute($key);
    }

    public function offsetSet($key, $value): void
    {
        $this->{$key} = $value;
    }

    public function offsetUnset($key): void
    {
        unset($this->attributes[$key]);
    }

    public function toArray(): array
    {
        $keys = array_keys($this->attributes);

        return array_map(function (string $key) {
            $value = $this->getAttribute($key);

            if ($value instanceof Entity) {
                return $value->toArray();
            }

            if (is_countable($value)) {
                return array_map(static function ($item) {
                    return $item instanceof Entity
                        ? $item->toArray()
                        : $item;
                }, $value instanceof Collection ? $value->toArray() : $value);
            }

            return $value;
        }, array_combine($keys, $keys));
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toJson($options = 0): string
    {
        $json = json_encode($this->jsonSerialize(), $options);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new JsonEncodingException(
                'Error encoding UPS entity [' . get_class($this) . '] to JSON: ' . json_last_error_msg()
            );
        }

        return $json;
    }

    public function simpleXmlTagName(): string
    {
        return class_basename($this);
    }

    public function toSimpleXml(?SimpleXMLElement $parent = null, bool $asChild = true): SimpleXMLElement
    {
        if (method_exists($this, 'startingSimpleXml')) {
            $this->startingSimpleXml();
        }

        if (is_null($parent)) {
            $parent = new SimpleXMLElement('<' . $this->simpleXmlTagName() . ' />');
        }

        $xml = $asChild
            ? $parent->addChild($this->simpleXmlTagName())
            : $parent;

        foreach ($this->attributes as $key => $value) {
            // Let's make sure we have a mutated version of the value, if a custom
            // accessor exists for the attribute.
            $value = $this->getAttribute($key);

            $this->appendXmlNode($xml, $key, $value);
        }

        return $xml;
    }

    public static function fromXml(SimpleXMLElement $xml): self
    {
        $instance = new static;

        $data = $instance->convertPropertyNamesToSnakeCase(Xml::toArray($xml));

        return $instance->fill($data);
    }

    public function fill(array $attributes): self
    {
        foreach ($attributes as $key => $value) {
            $this->setAttribute($key, $value);
        }

        if (method_exists($this, 'filled')) {
            $this->filled($this->attributes);
        }

        return $this;
    }

    protected function hasAttributeKeyMap(string $key): bool
    {
        return array_key_exists($key, $this->attributeKeyMap);
    }

    public function getAttribute($key)
    {
        $value = $this->attributes[$key] ?? null;

        if ($this->castEmptyArraysAsTrue && is_array($value) && empty($value) && $this->hasCast($key, ['boolean', 'bool'])) {
            $value = true;
        } else {
            $value = $this->hasAttributesGetAttribute($key);
        }

        // boolean casted values should always be some kind of boolean value.
        if (is_null($value) && $this->hasCast($key, ['boolean', 'bool'])) {
            return false;
        }

        return $value;
    }

    public function setAttribute($key, $value)
    {
        if ($this->hasAttributeKeyMap($key)) {
            $key = $this->attributeKeyMap[$key];
        }

        return $this->hasAttributesSetAttribute($key, $value);
    }

    protected function appendXmlNode(SimpleXMLElement $xml, string $key, $value): void
    {
        $key = $this->attributeKeyToXmlTag($key);

        if ($value instanceof self) {
            $value->toSimpleXml($xml);

            return;
        }

        if (is_countable($value)) {
            foreach ($value as $arrayKey => $arrayValue) {
                if (is_numeric($arrayKey)) {
                    $this->appendXmlNode($xml, $key, $arrayValue);
                } else {
                    $child = $xml->addChild($key);

                    $this->appendXmlNode($child, $arrayKey, $arrayValue);
                }
            }

            return;
        }

        if ($value === true) {
            $xml->addChild($key);
        } elseif (! empty($value) && $value !== false) {
            $xml->addChild($key, htmlspecialchars($value));
        }
    }

    protected function attributeKeyToXmlTag(string $key): string
    {
        $tag = ucfirst(Str::studly($key));

        $accessorFunctionName = "get{$tag}XmlTag";

        if (method_exists($this, $accessorFunctionName)) {
            return $this->{$accessorFunctionName}();
        }

        return $tag;
    }

    /*
     * Methods needed for Laravel's HasAttributes::getAttribute() method to work
     */
    public function getIncrementing(): bool
    {
        return false;
    }

    public function usesTimestamps(): bool
    {
        return false;
    }

    public function relationLoaded(): bool
    {
        return false;
    }

    /*
     * Overridden to prevent Laravel from thinking we need to
     * query for a relationship.
     */
    protected function getRelationshipFromMethod(): string
    {
        return '';
    }
}
