<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Shipment\Label;

use Rawilk\Ups\Entity\Shipment\Label\LabelStockSize;
use Rawilk\Ups\Exceptions\InvalidAttribute;
use Rawilk\Ups\Tests\TestCase;

class LabelStockSizeTest extends TestCase
{
    /** @test */
    public function sets_width_and_height_automatically(): void
    {
        $expected = <<<XML
        <LabelStockSize>
            <Height>4</Height>
            <Width>6</Width>
        </LabelStockSize>
        XML;

        self::assertXmlStringEqualsXmlString(
            $expected,
            (new LabelStockSize)->toSimpleXml(null, false)->asXML()
        );
    }

    /** @test */
    public function width_can_be_customized(): void
    {
        $expected = <<<XML
        <LabelStockSize>
            <Height>4</Height>
            <Width>8</Width>
        </LabelStockSize>
        XML;

        $entity = new LabelStockSize([
            'width' => '8',
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }

    /** @test */
    public function throws_exceptions_for_invalid_width(): void
    {
        $this->expectException(InvalidAttribute::class);

        new LabelStockSize([
            'width' => '4',
        ]);
    }

    /** @test */
    public function throws_exceptions_for_invalid_height(): void
    {
        $this->expectException(InvalidAttribute::class);

        new LabelStockSize([
            'height' => '6',
        ]);
    }
}
