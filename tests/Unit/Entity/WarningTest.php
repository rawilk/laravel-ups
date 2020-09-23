<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity;

use Rawilk\Ups\Entity\Warning;
use Rawilk\Ups\Tests\TestCase;
use SimpleXMLElement;

class WarningTest extends TestCase
{
    /** @test */
    public function creates_from_xml(): void
    {
        $xml = <<<XML
        <Warning>
            <ErrorCode>1</ErrorCode>
            <ErrorDescription>Some error</ErrorDescription>
            <ErrorSeverity>foo</ErrorSeverity>
        </Warning>
        XML;

        $warning = Warning::fromXml(new SimpleXMLElement($xml));

        self::assertEquals('1', $warning->code);
        self::assertEquals('Some error', $warning->description);
        self::assertNull($warning->error_severity);
    }
}
