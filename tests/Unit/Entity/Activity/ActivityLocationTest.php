<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Activity\ActivityLocation;
use Rawilk\Ups\Entity\Activity\AddressArtifactFormat;

it('converts to xml', function () {
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

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $entity->toSimpleXml(null, false)->asXML(),
    );
});
