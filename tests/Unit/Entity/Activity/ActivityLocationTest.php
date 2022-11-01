<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Activity;

use Rawilk\Ups\Entity\Activity\ActivityLocation;
use Rawilk\Ups\Entity\Activity\AddressArtifactFormat;
use Rawilk\Ups\Tests\TestCase;

class ActivityLocationTest extends TestCase
{
    /** @test */
    public function converts_to_xml(): void
    {
        $expected = <<<'XML'
        <ActivityLocation>
            <AddressArtifactFormat>
                <Country>US</Country>
            </AddressArtifactFormat>
        </ActivityLocation>
        XML;

        $entity = new ActivityLocation([
            'address_artifact_format' => new AddressArtifactFormat([
                'country' => 'US',
            ]),
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }
}
