<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions;

use Rawilk\Ups\Entity\Entity;
use Rawilk\Ups\Entity\Notification\EMailMessage;

/**
 * @property bool $label_links
 *      Indicates the Label and Receipt URL's links that needs to be returned in
 *      the XML response.
 * @property null|\Rawilk\Ups\Entity\Notification\EMailMessage $email_message
 */
class LabelDelivery extends Entity
{
    protected array $attributeKeyMap = [
        'e_mail_message' => 'email_message',
    ];

    protected $casts = [
        'label_links' => 'boolean',
    ];

    public function getLabelLinksXmlTag(): string
    {
        return 'LabelLinksIndicator';
    }

    public function emailMessage(): string
    {
        return EMailMessage::class;
    }
}
