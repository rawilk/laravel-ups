<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\AddressValidation;

use Rawilk\Ups\Entity\AddressValidation\AddressClassification;
use Rawilk\Ups\Entity\AddressValidation\AddressValidationAddress;
use Rawilk\Ups\Tests\Concerns\UsesFilesystem;
use Rawilk\Ups\Tests\TestCase;
use SimpleXMLElement;

class AddressValidationAddressTest extends TestCase
{
    use UsesFilesystem;

    /** @test */
    public function can_be_created_from_xml(): void
    {
        $xml = $this->getXmlContent('address-validation-address');

        $entity = AddressValidationAddress::fromXml($xml);

        $expected = [
            'address_line1' => '7510 AIRWAY RD',
            'address_line2' => 'STE 7',
            'city' => 'SAN DIEGO',
            'state' => 'CA',
            'postal_code' => '92154-8034',
            'country_code' => 'US',
            'region' => 'SAN DIEGO CA 92154-8034',
        ];

        self::assertEquals($expected, $entity->toArray());
    }

    /** @test */
    public function can_have_address_classification(): void
    {
        $xml = <<<XML
        <AddressKeyFormat>
            <AddressLine>123 Any street</AddressLine>
            <AddressClassification>
                <Code>1</Code>
                <Description>Commercial</Description>
            </AddressClassification>
        </AddressKeyFormat>
        XML;

        $entity = AddressValidationAddress::fromXml(new SimpleXMLElement($xml));

        self::assertInstanceOf(AddressClassification::class, $entity->address_classification);
        self::assertSame(1, $entity->address_classification->code);
        self::assertSame('Commercial', $entity->address_classification->description);
        self::assertSame('123 Any street', $entity->address_line1);
    }
}
