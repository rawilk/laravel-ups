<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Location;

use Rawilk\Ups\Entity\Location\AccessPointSearch;
use Rawilk\Ups\Entity\Location\LocationSearchCriteria;
use Rawilk\Ups\Exceptions\InvalidMaxListSize;
use Rawilk\Ups\Exceptions\InvalidSearchRadius;
use Rawilk\Ups\Tests\TestCase;

class LocationSearchCriteriaTest extends TestCase
{
    /** @test */
    public function converts_to_xml(): void
    {
        $expected = <<<XML
        <LocationSearchCriteria>
            <MaximumListSize>1</MaximumListSize>
            <SearchRadius>50</SearchRadius>
        </LocationSearchCriteria>
        XML;

        $entity = new LocationSearchCriteria([
            'maximum_list_size' => 1,
            'search_radius' => 50,
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }

    /** @test */
    public function can_have_access_point_search(): void
    {
        $expected = <<<XML
        <LocationSearchCriteria>
            <MaximumListSize>1</MaximumListSize>
            <SearchRadius>100</SearchRadius>
            <AccessPointSearch>
                <AccessPointStatus>01</AccessPointStatus>
                <PublicAccessPointID>123456</PublicAccessPointID>
            </AccessPointSearch>
        </LocationSearchCriteria>
        XML;

        $entity = new LocationSearchCriteria([
            'maximum_list_size' => 1,
            'access_point_search' => new AccessPointSearch([
                'access_point_status' => AccessPointSearch::STATUS_ACTIVE_AVAILABLE,
                'public_access_point_id' => '123456',
            ]),
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }

    /**
     * @test
     * @dataProvider invalidListSizes
     * @param int $size
     */
    public function throws_an_exception_for_invalid_list_size(int $size): void
    {
        $this->expectException(InvalidMaxListSize::class);

        new LocationSearchCriteria([
            'maximum_list_size' => $size,
        ]);
    }

    /**
     * @test
     * @dataProvider invalidRadiuses
     * @param int $radius
     */
    public function throws_an_exception_for_invalid_search_radius(int $radius): void
    {
        $this->expectException(InvalidSearchRadius::class);

        new LocationSearchCriteria([
            'search_radius' => $radius,
        ]);
    }

    public function invalidListSizes(): array
    {
        return [
            [-1],
            [51],
        ];
    }

    public function invalidRadiuses(): array
    {
        return [
            [4],
            [151],
        ];
    }
}
