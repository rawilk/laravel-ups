<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Location;

use Rawilk\Ups\Entity\Location\DayOfWeek;
use Rawilk\Ups\Tests\TestCase;
use SimpleXMLElement;

class DayOfWeekTest extends TestCase
{
    /** @test */
    public function can_be_created_from_xml(): void
    {
        $xml = <<<XML
        <DayOfWeek>
            <Day>1</Day>
            <OpenHours>1100</OpenHours>
            <CloseHours>1700</CloseHours>
            <LatestDropOffHours>1630</LatestDropOffHours>
        </DayOfWeek>
        XML;

        $entity = DayOfWeek::fromXml(new SimpleXMLElement($xml));

        self::assertIsInt($entity->day);
        self::assertSame(1, $entity->day);
        self::assertSame('1100', $entity->open_hours);
        self::assertSame('1700', $entity->close_hours);
        self::assertSame('1630', $entity->latest_drop_off_hours);
        self::assertFalse($entity->closed);
        self::assertFalse($entity->open24_hours);
    }

    /** @test */
    public function can_be_closed(): void
    {
        $xml = <<<XML
        <DayOfWeek>
            <Day>2</Day>
            <ClosedIndicator />
        </DayOfWeek>
        XML;

        $entity = DayOfWeek::fromXml(new SimpleXMLElement($xml));

        self::assertSame(2, $entity->day);
        self::assertTrue($entity->closed);
    }

    /** @test */
    public function can_be_open_24_hours(): void
    {
        $xml = <<<XML
        <DayOfWeek>
            <Day>2</Day>
            <Open24HoursIndicator />
        </DayOfWeek>
        XML;

        $entity = DayOfWeek::fromXml(new SimpleXMLElement($xml));

        self::assertSame(2, $entity->day);
        self::assertTrue($entity->open24_hours);
    }
}
