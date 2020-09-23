<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Payment;

use Rawilk\Ups\Concerns\HasMonetaryValue;
use Rawilk\Ups\Entity\Entity;

class InvoiceLineTotal extends Entity
{
    use HasMonetaryValue;
}
