<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Shipment;

use Rawilk\Ups\Entity\Shipment\PackageResult;
use Rawilk\Ups\Tests\TestCase;
use SimpleXMLElement;

class PackageResultTest extends TestCase
{
    /** @test */
    public function creates_from_xml(): void
    {
        $xml = <<<'XML'
        <PackageResult>
            <TrackingNumber>1Z...</TrackingNumber>
        </PackageResult>
        XML;

        $entity = PackageResult::fromXml(new SimpleXMLElement($xml));

        self::assertEquals('1Z...', $entity->tracking_number);
    }
}
