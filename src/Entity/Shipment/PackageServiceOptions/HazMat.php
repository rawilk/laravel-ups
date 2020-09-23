<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment\PackageServiceOptions;

use Rawilk\Ups\Entity\Entity;
use Rawilk\Ups\Exceptions\InvalidAttribute;

/**
 * @property int $packaging_type_quantity
 *      The number of pieces of the specific commodity.
 * @property string $sub_risk_class
 * @property string $adr_item_number
 *      The type of regulated goods for an ADR package where ADR is for Europe to Europe ground movement.
 * @property string $adr_packaging_group_letter
 * @property string $technical_name
 * @property string $hazard_label_required
 *      Defines the type of label that is required on the package for the commodity.
 * @property string $class_division_number
 * @property string $reference_number
 * @property string $quantity
 * @property string $uom
 * @property string $packagingType
 * @property string $id_number
 * @property string $proper_shipping_name
 * @property null|string $additional_description
 * @property null|string $packaging_group_type
 * @property null|string $packaging_instruction_code
 * @property null|string $emergency_phone
 * @property null|string $emergency_contact
 * @property null|string $reportable_quantity
 * @property string $regulation_set
 * @property string $transportation_mode
 * @property string $commodity_regulated_level_code
 * @property string $transport_category Valid values are between 0 to 4.
 * @property string $tunnel_restriction_code
 * @property string $chemical_record_identifier
 * @property null|string $local_proper_shipping_name
 */
class HazMat extends Entity
{
    /** @var int */
    public const MIN_PACKAGING_TYPE_QUANTITY = 1;

    /** @var int */
    public const MAX_PACKAGING_TYPE_QUANTITY = 999;

    public function getAdrItemNumberXmlTag(): string
    {
        return 'aDRItemNumber';
    }

    public function getAdrPackagingGroupLetterXmlTag(): string
    {
        return 'aDRPackagingGroupLetter';
    }

    public function getIdNumberXmlTag(): string
    {
        return 'IDNumber';
    }

    public function setPackagingTypeQuantityAttribute(int $quantity): void
    {
        if (! $this->isPackagingTypeQuantityValid($quantity)) {
            throw InvalidAttribute::withMessage(
                sprintf(
                    'Invalid packaging type quantity. Valid values are between %s and %s.',
                    self::MIN_PACKAGING_TYPE_QUANTITY,
                    self::MAX_PACKAGING_TYPE_QUANTITY
                )
            );
        }

        $this->attributes['packaging_type_quantity'] = $quantity;
    }

    protected function isPackagingTypeQuantityValid(int $quantity): bool
    {
        return $quantity >= self::MIN_PACKAGING_TYPE_QUANTITY
            && $quantity <= self::MAX_PACKAGING_TYPE_QUANTITY;
    }
}
