<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Notification\EMailMessage;

it('creates from xml', function () {
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

    expect($entity->email_address)->toBe('email@example.com')
        ->and($entity->undeliverable_email_address)->toBe('email')
        ->and($entity->from_email_address)->toBe('email@example.com')
        ->and($entity->from_name)->toBe('John Smith')
        ->and($entity->memo)->toBe('Some memo')
        ->and($entity->subject)->toBe('Important email message');
});

it('converts to xml', function () {
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

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $email->toSimpleXml(null, false)->asXML(),
    );
});
