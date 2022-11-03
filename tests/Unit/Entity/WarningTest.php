<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Warning;

it('creates from xml', function () {
    $xml = <<<'XML'
    <Warning>
        <ErrorCode>1</ErrorCode>
        <ErrorDescription>Some error</ErrorDescription>
        <ErrorSeverity>foo</ErrorSeverity>
    </Warning>
    XML;

    $warning = Warning::fromXml(new SimpleXMLElement($xml));

    expect($warning->code)->toBe('1')
        ->and($warning->description)->toBe('Some error')
        ->and($warning->error_severity)->toBeNull();
});
