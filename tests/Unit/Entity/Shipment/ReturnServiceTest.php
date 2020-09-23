<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Shipment;

use Rawilk\Ups\Entity\Shipment\ReturnService;
use Rawilk\Ups\Tests\TestCase;

class ReturnServiceTest extends TestCase
{
    /** @test */
    public function sets_a_default_code(): void
    {
        $defaultCode = ReturnService::DEFAULT_SERVICE_CODE;

        $expected = <<<XML
        <ReturnService>
            <Code>{$defaultCode}</Code>
        </ReturnService>
        XML;

        $entity = new ReturnService;

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }

    /** @test */
    public function default_service_code_can_be_overridden(): void
    {
        $code = 'foo';

        $expected = <<<XML
        <ReturnService>
            <Code>{$code}</Code>
        </ReturnService>
        XML;

        $entity = new ReturnService([
            'code' => $code,
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }

    /** @test */
    public function can_get_a_list_of_available_services(): void
    {
        $services = ReturnService::availableServices();

        self::assertIsArray($services);
        self::assertNotEmpty($services);
    }
}
