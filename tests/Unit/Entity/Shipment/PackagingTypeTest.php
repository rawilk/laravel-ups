<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Shipment;

use Rawilk\Ups\Entity\Shipment\PackagingType;
use Rawilk\Ups\Tests\TestCase;

class PackagingTypeTest extends TestCase
{
    /** @test */
    public function code_has_a_default(): void
    {
        $default = PackagingType::DEFAULT_TYPE;

        $expected = <<<XML
        <PackagingType>
            <Code>{$default}</Code>
            <Description>Foo</Description>
        </PackagingType>
        XML;

        $entity = new PackagingType([
            'description' => 'Foo',
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }
}
