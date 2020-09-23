<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Location;

use Rawilk\Ups\Entity\Location\IVR;
use Rawilk\Ups\Tests\TestCase;
use SimpleXMLElement;

class IVRTest extends TestCase
{
    /** @test */
    public function creates_from_xml(): void
    {
        $xml = <<<XML
        <IVR>
            <PhraseID>foo</PhraseID>
            <TextToSpeechIndicator />
        </IVR>
        XML;

        $ivr = IVR::fromXml(new SimpleXMLElement($xml));

        self::assertSame('foo', $ivr->phrase_id);
        self::assertIsBool($ivr->text_to_speech);
        self::assertTrue($ivr->text_to_speech);
    }
}
