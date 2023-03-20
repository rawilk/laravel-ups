<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment;

use Rawilk\Ups\Entity\Entity;

/**
 * @property bool $barcode
 * @property string $code
 *      Reference Number type code. For the entire shipment, the code specifies the reference name.
 * @property string $value
 *      The customer supplied reference number.
 */
class ReferenceNumber extends Entity
{
    /** @var int */
    public const MAX_VALUE_LENGTH = 35;

    /** @var int */
    public const MAX_ALPHANUMERIC_VALUE_LENGTH = 14;

    /** @var int */
    public const MAX_NUMERIC_VALUE_LENGTH = 24;

    // Codes
    public const ACCOUNTS_RECEIVABLE_CUSTOMER_ACCOUNT = 'AJ';

    public const APPROPRIATION_NUMBER = 'AT';

    public const BILL_OF_LADING_NUMBER = 'BM';

    public const COLLECT_ON_DELIVERY_COD_NUMBER = '9V';

    public const DEALER_ORDER_NUMBER = 'ON';

    public const DEPARTMENT_NUMBER = 'DP';

    public const FOOD_AND_DRUG_ADMINISTRATION_PRODUCT_CODE = '3Q';

    public const INVOICE_NUMBER = 'IK';

    public const MANIFEST_KEY_NUMBER = 'MK';

    public const MODEL_NUMBER = 'MJ';

    public const PART_NUMBER = 'PM';

    public const PRODUCTION_CODE = 'PC';

    public const PURCHASE_ORDER_NUMBER = 'PO';

    public const PURCHASE_REQUEST_NUMBER = 'RQ';

    public const RETURN_AUTHORIZATION_NUMBER = 'RZ';

    public const SALESPERSON_NUMBER = 'SA';

    public const SERIAL_NUMBER = 'SE';

    public const STORE_NUMBER = 'ST';

    public const TRANSACTION_REFERENCE_NUMBER = 'TN';

    public const EMPLOYER_ID_NUMBER = 'EI';

    public const FEDERAL_TAXPAYER_ID = 'TJ';

    public const SOCIAL_SECURITY_NUMBER = 'SY';

    protected array $attributeKeyMap = [
        'barcode_indicator' => 'barcode',
    ];

    protected $casts = [
        'barcode' => 'boolean',
    ];

    public function getBarcodeXmlTag(): string
    {
        return 'BarcodeIndicator';
    }

    public function getValueAttribute($value): string
    {
        if (is_null($value)) {
            return '';
        }

        return $this->truncateValue($value);
    }

    protected function truncateValue(string $value): string
    {
        if ($this->barcode) {
            return $this->truncateBarcodeValue($value);
        }

        if (strlen($value) > self::MAX_VALUE_LENGTH) {
            return substr($value, 0, self::MAX_VALUE_LENGTH);
        }

        return $value;
    }

    protected function truncateBarcodeValue(string $value): string
    {
        // Barcode value must not have any spaces
        $value = preg_replace('/\s+/', '', $value);

        if (is_numeric($value) && strlen($value) > self::MAX_NUMERIC_VALUE_LENGTH) {
            return substr($value, 0, self::MAX_NUMERIC_VALUE_LENGTH);
        }

        if (ctype_alnum($value) && strlen($value) > self::MAX_ALPHANUMERIC_VALUE_LENGTH) {
            return substr($value, 0, self::MAX_ALPHANUMERIC_VALUE_LENGTH);
        }

        return $value;
    }
}
