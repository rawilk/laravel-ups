<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Shipment;

use Rawilk\Ups\Entity\Shipment\PackageLevelResult;
use Rawilk\Ups\Tests\TestCase;
use SimpleXMLElement;

class PackageLevelResultTest extends TestCase
{
    /** @test */
    public function creates_from_xml(): void
    {
        $xml = <<<XML
        <Element>
            <TrackingNumber>1Z...</TrackingNumber>
            <StatusCode>1</StatusCode>
            <Description>Voided</Description>
        </Element>
        XML;

        $entity = PackageLevelResult::fromXml(new SimpleXMLElement($xml));

        self::assertEquals('1Z...', $entity->tracking_number);
        self::assertEquals('1', $entity->status_code);
        self::assertEquals('Voided', $entity->description);

        self::assertTrue($entity->voided());
        self::assertFalse($entity->notVoided());
    }

    /** @test */
    public function can_handle_complex_status_code(): void
    {
        $xml = <<<XML
        <Element>
            <TrackingNumber>1Z...</TrackingNumber>
            <StatusCode>
                <Code>0</Code>
            </StatusCode>
        </Element>
        XML;

        $entity = PackageLevelResult::fromXml(new SimpleXMLElement($xml));

        self::assertTrue($entity->notVoided());
        self::assertFalse($entity->voided());

        self::assertEquals('0', $entity->getStatusCode());
    }
}
