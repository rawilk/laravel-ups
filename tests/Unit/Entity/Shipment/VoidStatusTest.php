<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Shipment;

use Rawilk\Ups\Entity\Shipment\VoidStatus;
use Rawilk\Ups\Tests\TestCase;
use SimpleXMLElement;

class VoidStatusTest extends TestCase
{
    /** @test */
    public function can_be_partially_voided(): void
    {
        $xml = <<<'XML'
        <VoidStatus>
            <StatusCode>
                <Code>2</Code>
            </StatusCode>
        </VoidStatus>
        XML;

        $voidStatus = VoidStatus::fromXml(new SimpleXMLElement($xml));

        self::assertTrue($voidStatus->partiallyVoided());
        self::assertFalse($voidStatus->failed());

        // A partial void will also show as "successful"
        self::assertTrue($voidStatus->successful());
    }

    /** @test */
    public function can_be_successful(): void
    {
        $xml = <<<'XML'
        <VoidStatus>
            <StatusCode>
                <Code>1</Code>
            </StatusCode>
        </VoidStatus>
        XML;

        $voidStatus = VoidStatus::fromXml(new SimpleXMLElement($xml));

        self::assertTrue($voidStatus->successful());
        self::assertFalse($voidStatus->failed());
        self::assertFalse($voidStatus->partiallyVoided());
    }

    /** @test */
    public function can_be_failed(): void
    {
        $xml = <<<'XML'
        <VoidStatus>
            <StatusCode>
                <Code>0</Code>
            </StatusCode>
        </VoidStatus>
        XML;

        $voidStatus = VoidStatus::fromXml(new SimpleXMLElement($xml));

        self::assertFalse($voidStatus->successful());
        self::assertTrue($voidStatus->failed());
        self::assertFalse($voidStatus->partiallyVoided());
    }
}
