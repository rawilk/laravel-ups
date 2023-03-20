<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Shipment\Label;

use Rawilk\Ups\Entity\Shipment\Label\Instruction;
use Rawilk\Ups\Entity\Shipment\Label\LabelPrintMethod;
use Rawilk\Ups\Entity\Shipment\Label\LabelSpecification;
use Rawilk\Ups\Entity\Shipment\Label\LabelStockSize;
use Rawilk\Ups\Tests\TestCase;

class LabelSpecificationTest extends TestCase
{
    /** @test */
    public function converts_to_xml(): void
    {
        $expected = <<<'XML'
        <LabelSpecification>
            <HTTPUserAgent>foo</HTTPUserAgent>
            <CharacterSet>nld</CharacterSet>
            <Instruction>
                <Code>foo</Code>
            </Instruction>
            <LabelPrintMethod>
                <Code>SPL</Code>
            </LabelPrintMethod>
            <LabelStockSize>
                <Height>4</Height>
                <Width>6</Width>
            </LabelStockSize>
        </LabelSpecification>
        XML;

        $entity = new LabelSpecification([
            'http_user_agent' => 'foo',
            'character_set' => LabelSpecification::CHAR_DUTCH,
            'instruction' => new Instruction([
                'code' => 'foo',
            ]),
            'label_print_method' => new LabelPrintMethod([
                'code' => LabelPrintMethod::SPL,
            ]),
            'label_stock_size' => new LabelStockSize,
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }

    /** @test */
    public function can_be_sent_as_gif(): void
    {
        $expected = <<<'XML'
        <LabelSpecification>
            <LabelPrintMethod>
                <Code>GIF</Code>
            </LabelPrintMethod>
            <LabelImageFormat>
                <Code>GIF</Code>
            </LabelImageFormat>
            <HTTPUserAgent>foo</HTTPUserAgent>
        </LabelSpecification>
        XML;

        $entity = LabelSpecification::asGIF()->setAttribute('http_user_agent', 'foo');

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }

    /** @test */
    public function can_be_sent_as_png(): void
    {
        $expected = <<<'XML'
        <LabelSpecification>
            <LabelPrintMethod>
                <Code>GIF</Code>
            </LabelPrintMethod>
            <LabelImageFormat>
                <Code>PNG</Code>
            </LabelImageFormat>
            <HTTPUserAgent>foo</HTTPUserAgent>
        </LabelSpecification>
        XML;

        $entity = LabelSpecification::asPNG()->setAttribute('http_user_agent', 'foo');

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }
}
