<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Shipment\ReferenceNumber;

it('converts to xml', function () {
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

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $entity->toSimpleXml(null, false)->asXML(),
    );
});

it('truncates value automatically', function () {
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

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $entity->toSimpleXml(null, false)->asXML(),
    );
});

test('barcode numeric values get truncated correctly', function () {
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

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $entity->toSimpleXml(null, false)->asXML(),
    );
});

test('barcode alphanumeric values get truncated automatically', function () {
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

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $entity->toSimpleXml(null, false)->asXML(),
    );
});
