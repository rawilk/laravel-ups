<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Notification;

use Rawilk\Ups\Entity\Notification\EMailMessage;
use Rawilk\Ups\Tests\TestCase;
use SimpleXMLElement;

class EMailMessageTest extends TestCase
{
    /** @test */
    public function creates_from_xml(): void
    {
        $xml = <<<'XML'
        <EMailMessage>
            <EMailAddress>email@example.com</EMailAddress>
            <UndeliverableEMailAddress>email</UndeliverableEMailAddress>
            <FromEMailAddress>email@example.com</FromEMailAddress>
            <FromName>John Smith</FromName>
            <Memo>Some memo</Memo>
            <Subject>Important email message</Subject>
        </EMailMessage>
        XML;

        $entity = EMailMessage::fromXml(new SimpleXMLElement($xml));

        self::assertSame('email@example.com', $entity->email_address);
        self::assertSame('email', $entity->undeliverable_email_address);
        self::assertSame('email@example.com', $entity->from_email_address);
        self::assertSame('John Smith', $entity->from_name);
        self::assertEquals('Some memo', $entity->memo);
        self::assertEquals('Important email message', $entity->subject);
    }

    /** @test */
    public function converts_to_xml(): void
    {
        $expected = <<<'XML'
        <EMailMessage>
            <EMailAddress>email@example.com</EMailAddress>
            <UndeliverableEMailAddress>email</UndeliverableEMailAddress>
            <FromEMailAddress>email@example.com</FromEMailAddress>
            <FromName>John Smith</FromName>
            <Memo>Some memo</Memo>
            <Subject>Important email message</Subject>
        </EMailMessage>
        XML;

        $email = new EMailMessage([
            'email_address' => 'email@example.com',
            'undeliverable_email_address' => 'email',
            'from_email_address' => 'email@example.com',
            'from_name' => 'John Smith',
            'memo' => 'Some memo',
            'subject' => 'Important email message',
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $email->toSimpleXml(null, false)->asXML()
        );
    }
}
