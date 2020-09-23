<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Location;

use Rawilk\Ups\Entity\Address\AddressKeyFormat;
use Rawilk\Ups\Entity\Location\Distance;
use Rawilk\Ups\Entity\Location\DropLocation;
use Rawilk\Ups\Entity\Location\Geocode;
use Rawilk\Ups\Entity\Location\IVR;
use Rawilk\Ups\Entity\UnitOfMeasurement;
use Rawilk\Ups\Tests\TestCase;
use SimpleXMLElement;

class DropLocationTest extends TestCase
{
    /** @test */
    public function creates_from_xml(): void
    {
        $xml = <<<XML
        <DropLocation>
            <LocationID>1234</LocationID>
            <IVR>
                <PhraseID>0</PhraseID>
            </IVR>
            <Geocode>
                <Latitude>34.10262680</Latitude>
                <Longitude>-84.2099075</Longitude>
            </Geocode>
            <AddressKeyFormat>
                <ConsigneeName>UPS STORE 2 - </ConsigneeName>
                <AddressLine>319 CURIE DR</AddressLine>
                <PoliticalDivision2>ALPHARETTA</PoliticalDivision2>
                <PoliticalDivision1>GA</PoliticalDivision1>
                <PostcodePrimaryLow>30005</PostcodePrimaryLow>
                <CountryCode>US</CountryCode>
            </AddressKeyFormat>
            <OriginOrDestination>01</OriginOrDestination>
            <EMailAddress>email@example.com</EMailAddress>
            <AdditionalChargeIndicator />
            <DisplayPhoneNumberIndicator>1</DisplayPhoneNumberIndicator>
            <LocationNewIndicator>Y</LocationNewIndicator>
            <WillCallLocationIndicator>N</WillCallLocationIndicator>
            <Distance>
                <Value>1.3</Value>
                <UnitOfMeasurement>
                    <Code>MI</Code>
                    <Description>MILES</Description>
                </UnitOfMeasurement>
            </Distance>
            <LatestGroundDropOffTime>Mon: 9:00am; Tue-Sun: No Pickup</LatestGroundDropOffTime>
            <PhoneNumber>276-328-7462</PhoneNumber>
            <FaxNumber>237-628-7362</FaxNumber>
        </DropLocation>
        XML;

        $dropLocation = DropLocation::fromXml(new SimpleXMLElement($xml));

        self::assertEquals('1234', $dropLocation->location_id);

        self::assertInstanceOf(IVR::class, $dropLocation->ivr);
        self::assertEquals('0', $dropLocation->ivr->phrase_id);

        self::assertInstanceOf(Geocode::class, $dropLocation->geocode);
        self::assertSame('34.10262680', $dropLocation->geocode->latitude);
        self::assertSame('-84.2099075', $dropLocation->geocode->longitude);

        self::assertInstanceOf(AddressKeyFormat::class, $dropLocation->address);
        self::assertEquals('UPS STORE 2 - ', $dropLocation->address->consignee_name);
        self::assertEquals('ALPHARETTA', $dropLocation->address->city);

        self::assertTrue($dropLocation->isOriginFacility());
        self::assertFalse($dropLocation->isDestinationFacility());
        self::assertTrue($dropLocation->additional_charge);
        self::assertEquals('email@example.com', $dropLocation->email);

        self::assertTrue($dropLocation->display_phone_number);
        self::assertTrue($dropLocation->location_new);
        self::assertFalse($dropLocation->will_call_location);

        self::assertInstanceOf(Distance::class, $dropLocation->distance);
        self::assertInstanceOf(UnitOfMeasurement::class, $dropLocation->distance->unit_of_measurement);
        self::assertSame(1.3, $dropLocation->distance->value);

        self::assertEquals('Mon: 9:00am; Tue-Sun: No Pickup', $dropLocation->latest_ground_drop_off_time);
        self::assertEquals('276-328-7462', $dropLocation->phone_number);
        self::assertEquals('237-628-7362', $dropLocation->fax_number);
    }
}
