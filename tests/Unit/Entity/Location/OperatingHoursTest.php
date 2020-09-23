<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Location;

use Rawilk\Ups\Entity\Location\DayOfWeek;
use Rawilk\Ups\Entity\Location\OperatingHours;
use Rawilk\Ups\Entity\Location\StandardHours;
use Rawilk\Ups\Tests\TestCase;
use SimpleXMLElement;

class OperatingHoursTest extends TestCase
{
    /** @test */
    public function creates_from_xml(): void
    {
        $xml = <<<XML
        <OperatingHours>
            <StandardHours>
                <HoursType>10</HoursType>
                <DayOfWeek>
                    <Day>7</Day>
                </DayOfWeek>
            </StandardHours>
        </OperatingHours>
        XML;

        $entity = OperatingHours::fromXml(new SimpleXMLElement($xml));

        self::assertInstanceOf(StandardHours::class, $entity->standard_hours);
        self::assertEquals('10', $entity->standard_hours->hours_type);
        self::assertInstanceOf(DayOfWeek::class, $entity->standard_hours->days[0]);
    }
}
