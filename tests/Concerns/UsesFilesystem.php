<?php

namespace Rawilk\Ups\Tests\Concerns;

use Illuminate\Support\Str;
use SimpleXMLElement;

trait UsesFilesystem
{
    public function getXmlContent(string $file): SimpleXMLElement
    {
        if (! Str::endsWith($file, '.xml')) {
            $file .= '.xml';
        }

        $path = __DIR__."/../fixtures/xml/{$file}";

        return new SimpleXMLElement(
            file_get_contents($path)
        );
    }
}
