<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Activity;

use Carbon\Carbon;
use Rawilk\Ups\Entity\Activity\Activity;
use Rawilk\Ups\Entity\Activity\ActivityLocation;
use Rawilk\Ups\Entity\Address\Address;
use Rawilk\Ups\Entity\Tracking\Status;
use Rawilk\Ups\Tests\TestCase;
use SimpleXMLElement;

class ActivityTest extends TestCase
{
    /** @test */
    public function creates_from_xml(): void
    {
        $xml = <<<'XML'
        <Activity>
            <ActivityLocation>
                <Address>
                    <City>ANYTOWN</City>
                    <StateProvinceCode>GA</StateProvinceCode>
                    <PostalCode>30340</PostalCode>
                    <CountryCode>US</CountryCode>
                </Address>
                <Code>ML</Code>
                <Description>BACK DOOR</Description>
                <SignedForByName>HELEN SMITH</SignedForByName>
            </ActivityLocation>
            <Status>
                <StatusType>
                    <Code>D</Code>
                    <Description>DELIVERED</Description>
                </StatusType>
            </Status>
            <Date>20100610</Date>
            <Time>120000</Time>
            <GMTDate>2019-04-15</GMTDate>
            <GMTTime>15.40.17</GMTTime>
            <GMTOffset>-04:00</GMTOffset>
        </Activity>
        XML;

        $activity = Activity::fromXml(new SimpleXMLElement($xml));

        self::assertInstanceOf(ActivityLocation::class, $activity->activity_location);
        self::assertInstanceOf(Address::class, $activity->activity_location->address);
        self::assertInstanceOf(Status::class, $activity->status);
        self::assertEquals('ML', $activity->activity_location->code);
        self::assertTrue($activity->isDelivered());
        self::assertFalse($activity->isPickup());
        self::assertEquals('HELEN SMITH', $activity->signed_for_by_name);
        self::assertInstanceOf(Carbon::class, $activity->date_time);
        self::assertEquals('2019-04-15 15:40:17', $activity->date_time->format('Y-m-d H:i:s'));
    }
}
