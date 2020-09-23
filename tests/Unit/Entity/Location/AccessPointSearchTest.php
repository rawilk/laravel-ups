<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Location;

use Rawilk\Ups\Entity\Location\AccessPointSearch;
use Rawilk\Ups\Tests\TestCase;

class AccessPointSearchTest extends TestCase
{
    /** @test */
    public function can_be_converted_to_xml(): void
    {
        $entity = new AccessPointSearch([
            'access_point_status' => 'something',
            'public_access_point_id' => '111',
        ]);

        $expected = <<<XML
        <AccessPointSearch>
            <AccessPointStatus>something</AccessPointStatus>
            <PublicAccessPointID>111</PublicAccessPointID>
        </AccessPointSearch>
        XML;

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }
}
