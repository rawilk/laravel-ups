<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Notification;

use Rawilk\Ups\Entity\Entity;

/**
 * @property string $email_address
 * @property null|string $undeliverable_email_address
 * @property string $from_email_address
 * @property null|string $from_name
 * @property null|string $memo
 * @property null|string $subject
 * @property null|string $subject_code
 */
class EMailMessage extends Entity
{
    protected array $attributeKeyMap = [
        'e_mail_address' => 'email_address',
        'undeliverable_e_mail_address' => 'undeliverable_email_address',
        'from_e_mail_address' => 'from_email_address',
    ];

    public function getEmailAddressXmlTag(): string
    {
        return 'EMailAddress';
    }

    public function getFromEmailAddressXmlTag(): string
    {
        return 'FromEMailAddress';
    }

    public function getUndeliverableEmailAddressXmlTag(): string
    {
        return 'UndeliverableEMailAddress';
    }
}
