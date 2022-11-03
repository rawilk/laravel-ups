<?php

declare(strict_types=1);

use Carbon\Carbon;
use Rawilk\Ups\Entity\Activity\Activity;
use Rawilk\Ups\Entity\Activity\ActivityLocation;
use Rawilk\Ups\Entity\Address\Address;
use Rawilk\Ups\Entity\Tracking\Status;

it('creates from xml', function () {
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

    expect($activity->activity_location)->toBeInstanceOf(ActivityLocation::class)
        ->and($activity->activity_location->address)->toBeInstanceOf(Address::class)
        ->and($activity->status)->toBeInstanceOf(Status::class)
        ->and($activity->activity_location->code)->toBe('ML')
        ->and($activity->isDelivered())->toBeTrue()
        ->and($activity->isPickup())->toBeFalse()
        ->and($activity->signed_for_by_name)->toBe('HELEN SMITH')
        ->and($activity->date_time)->toBeInstanceOf(Carbon::class)
        ->and($activity->date_time->format('Y-m-d H:i:s'))->toBe('2019-04-15 15:40:17');
});
