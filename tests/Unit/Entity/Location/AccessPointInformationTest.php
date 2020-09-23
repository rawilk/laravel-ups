<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Location;

use Illuminate\Support\Collection;
use Rawilk\Ups\Entity\Location\AccessPointInformation;
use Rawilk\Ups\Entity\Location\AccessPointStatus;
use Rawilk\Ups\Entity\Location\BusinessClassification;
use Rawilk\Ups\Tests\TestCase;
use SimpleXMLElement;

class AccessPointInformationTest extends TestCase
{
    /** @test */
    public function can_be_created_from_xml(): void
    {
        $xml = <<<XML
        <Element>
            <PublicAccessPointID>123456</PublicAccessPointID>
            <ImageURL>http://example.com</ImageURL>
        </Element>
        XML;

        $entity = AccessPointInformation::fromXml(new SimpleXMLElement($xml));

        self::assertSame('123456', $entity->public_access_point_id);
        self::assertSame('http://example.com', $entity->image_url);
    }

    /** @test */
    public function can_have_access_point_status(): void
    {
        $xml = <<<XML
        <Element>
            <AccessPointStatus>
                <Code>01</Code>
                <Description>Active Available</Description>
            </AccessPointStatus>
        </Element>
        XML;

        $entity = AccessPointInformation::fromXml(new SimpleXMLElement($xml));

        self::assertInstanceOf(AccessPointStatus::class, $entity->access_point_status);
        self::assertSame('01', $entity->access_point_status->code);
        self::assertSame('Active Available', $entity->access_point_status->description);
    }

    /** @test */
    public function can_have_business_classifications(): void
    {
        $xml = <<<XML
        <Element>
            <BusinessClassificationList>
                <BusinessClassification>
                    <Code>01</Code>
                    <Description>Desc</Description>
                </BusinessClassification>
                <BusinessClassification>
                    <Code>02</Code>
                    <Description>Desc</Description>
                </BusinessClassification>
            </BusinessClassificationList>
        </Element>
        XML;

        $entity = AccessPointInformation::fromXml(new SimpleXMLElement($xml));

        self::assertInstanceOf(Collection::class, $entity->business_classifications);
        self::assertContainsOnlyInstancesOf(BusinessClassification::class, $entity->business_classifications);
        self::assertCount(2, $entity->business_classifications);
        self::assertSame('01', $entity->business_classifications->first()->code);
        self::assertSame('02', $entity->business_classifications[1]->code);
    }

    /** @test */
    public function can_handle_a_single_business_classification(): void
    {
        $xml = <<<XML
        <Element>
            <BusinessClassificationList>
                <BusinessClassification>
                    <Code>01</Code>
                    <Description>Desc</Description>
                </BusinessClassification>
            </BusinessClassificationList>
        </Element>
        XML;

        $entity = AccessPointInformation::fromXml(new SimpleXMLElement($xml));

        self::assertInstanceOf(BusinessClassification::class, $entity->business_classifications->first());
        self::assertSame('01', $entity->business_classifications->first()->code);
    }

    /** @test */
    public function business_classifications_always_returns_a_collection(): void
    {
        $entity = new AccessPointInformation;

        self::assertInstanceOf(Collection::class, $entity->business_classifications);
        self::assertCount(0, $entity->business_classifications);
    }
}
