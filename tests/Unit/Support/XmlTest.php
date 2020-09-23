<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Support;

use Rawilk\Ups\Support\Xml;
use Rawilk\Ups\Tests\Concerns\UsesFilesystem;
use Rawilk\Ups\Tests\TestCase;

class XmlTest extends TestCase
{
    use UsesFilesystem;

    /** @test */
    public function can_convert_simple_xml_element_to_array(): void
    {
        $xml = $this->getXmlContent('basic-xml');

        self::assertEquals([
            'Foo' => 'bar',
            'HasNestedValue' => [
                'NestedValue' => 'Hello world',
            ],
        ], Xml::toArray($xml));
    }
}
