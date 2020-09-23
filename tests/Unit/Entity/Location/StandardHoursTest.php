<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Location;

use Rawilk\Ups\Entity\Location\DayOfWeek;
use Rawilk\Ups\Entity\Location\StandardHours;
use Rawilk\Ups\Tests\TestCase;
use SimpleXMLElement;

class StandardHoursTest extends TestCase
{
    /** @test */
    public function creates_from_xml(): void
    {
        $xml = <<<XML
        <StandardHours>
            <HoursType>10</HoursType>
            <DayOfWeek>
                <Day>1</Day>
            </DayOfWeek>
            <DayOfWeek>
                <Day>2</Day>
            </DayOfWeek>
        </StandardHours>
        XML;

        $entity = StandardHours::fromXml(new SimpleXMLElement($xml));

        self::assertSame('10', $entity->hours_type);
        self::assertContainsOnlyInstancesOf(DayOfWeek::class, $entity->days);
        self::assertCount(2, $entity->days);
        self::assertEquals(1, $entity->days[0]->day);
        self::assertEquals(2, $entity->days[1]->day);
    }

    /** @test */
    public function days_always_returns_an_array(): void
    {
        $xml = <<<XML
        <Element>
            <HoursType>10</HoursType>
        </Element>
        XML;

        $entity = StandardHours::fromXml(new SimpleXMLElement($xml));

        self::assertIsArray($entity->days);
        self::assertEmpty($entity->days);
    }

    /** @test */
    public function can_handle_a_single_day_of_week(): void
    {
        $xml = <<<XML
        <StandardHours>
            <HoursType>10</HoursType>
            <DayOfWeek>
                <Day>1</Day>
            </DayOfWeek>
        </StandardHours>
        XML;

        $entity = StandardHours::fromXml(new SimpleXMLElement($xml));

        self::assertIsArray($entity->days);
        self::assertCount(1, $entity->days);
        self::assertEquals(1, $entity->days[0]->day);
    }
}
