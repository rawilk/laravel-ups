<?php

declare(strict_types=1);

namespace Rawilk\Ups\Support;

use SimpleXMLElement;

class Xml
{
    public static function toArray(SimpleXMLElement $xml): array
    {
        return json_decode(json_encode($xml), true);
    }
}
