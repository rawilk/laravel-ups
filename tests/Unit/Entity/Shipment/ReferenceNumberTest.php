<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Shipment;

use Rawilk\Ups\Entity\Shipment\ReferenceNumber;
use Rawilk\Ups\Tests\TestCase;

class ReferenceNumberTest extends TestCase
{
    /** @test */
    public function converts_to_xml(): void
    {
        $code = ReferenceNumber::INVOICE_NUMBER;

        $expected = <<<XML
        <ReferenceNumber>
            <Code>{$code}</Code>
            <Value>foo</Value>
            <BarcodeIndicator />
        </ReferenceNumber>
        XML;

        $entity = new ReferenceNumber([
            'code' => ReferenceNumber::INVOICE_NUMBER,
            'value' => 'foo',
            'barcode' => true,
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }

    /** @test */
    public function value_gets_truncated_automatically(): void
    {
        $value = str_repeat('a', ReferenceNumber::MAX_VALUE_LENGTH);
        $tooLong = str_repeat('a', ReferenceNumber::MAX_VALUE_LENGTH + 1);
        $code = ReferenceNumber::INVOICE_NUMBER;

        $expected = <<<XML
        <ReferenceNumber>
            <Code>{$code}</Code>
            <Value>{$value}</Value>
        </ReferenceNumber>
        XML;

        $entity = new ReferenceNumber([
            'code' => $code,
            'value' => $tooLong,
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }

    /** @test */
    public function barcode_numeric_values_get_truncated_correctly(): void
    {
        $value = str_repeat('1', ReferenceNumber::MAX_NUMERIC_VALUE_LENGTH);
        $tooLong = str_repeat('1', ReferenceNumber::MAX_NUMERIC_VALUE_LENGTH + 1);
        $code = ReferenceNumber::INVOICE_NUMBER;

        $expected = <<<XML
        <ReferenceNumber>
            <Code>{$code}</Code>
            <Value>{$value}</Value>
            <BarcodeIndicator />
        </ReferenceNumber>
        XML;

        $entity = new ReferenceNumber([
            'code' => $code,
            'value' => $tooLong,
            'barcode' => true,
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }

    /** @test */
    public function barcode_alphanumeric_values_get_truncated_automatically(): void
    {
        $value = str_repeat('a', ReferenceNumber::MAX_ALPHANUMERIC_VALUE_LENGTH);
        $tooLong = str_repeat('a', ReferenceNumber::MAX_ALPHANUMERIC_VALUE_LENGTH + 1);
        $code = ReferenceNumber::INVOICE_NUMBER;

        $expected = <<<XML
        <ReferenceNumber>
            <Code>{$code}</Code>
            <Value>{$value}</Value>
            <BarcodeIndicator />
        </ReferenceNumber>
        XML;

        $entity = new ReferenceNumber([
            'code' => $code,
            'value' => $tooLong,
            'barcode' => true,
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }
}
