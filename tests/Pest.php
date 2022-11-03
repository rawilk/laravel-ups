<?php

declare(strict_types=1);

use Illuminate\Support\Str;
use Rawilk\Ups\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

// Helpers...
function getXmlContent(string $file): SimpleXMLElement
{
    $file = Str::finish($file, '.xml');

    $path = __DIR__ . "/fixtures/xml/{$file}";

    return new SimpleXMLElement(
        file_get_contents($path)
    );
}
