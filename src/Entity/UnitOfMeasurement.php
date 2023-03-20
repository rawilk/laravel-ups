<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity;

/**
 * @property string $code
 * @property null|string $description
 */
class UnitOfMeasurement extends Entity
{
    // Weights
    public const LBS = 'LBS'; // Pounds (default)

    public const KGS = 'KGS'; // Kilograms

    // Dimensions
    public const IN = 'IN'; // Inches

    public const CM = 'CM'; // Centimeters

    // Distances
    public const MI = 'MI'; // Miles

    public const KM = 'KM'; // Kilometers

    // Products
    public const PROD_BARREL = 'BA';

    public const PROD_BUNDLE = 'BE';

    public const PROD_BAG = 'BG';

    public const PROD_BUNCH = 'BH';

    public const PROD_BOX = 'BOX';

    public const PROD_BOLT = 'BT';

    public const PROD_BUTT = 'BU';

    public const PROD_CANISTER = 'CI';

    public const PROD_CENTIMETER = 'CM';

    public const PROD_CONTAINER = 'CON';

    public const PROD_CRATE = 'CR';

    public const PROD_CASE = 'CS';

    public const PROD_CARTON = 'CT';

    public const PROD_CYLINDER = 'CY';

    public const PROD_DOZEN = 'DOZ';

    public const PROD_EACH = 'EA';

    public const PROD_ENVELOPE = 'EN';

    public const PROD_FEET = 'FT';

    public const PROD_KILOGRAM = 'KG';

    public const PROD_POUND = 'LB';

    public const PROD_POUNDS = 'LBS';

    public const PROD_LITER = 'L';

    public const PROD_METER = 'M';

    public const PROD_NUMBER = 'NMB';

    public const PROD_PACKET = 'PA';

    public const PROD_PALLET = 'PAL';

    public const PROD_PIECE = 'PC';

    public const PROD_PIECES = 'PCS';

    public const PROD_PROOF_LITERS = 'PF';

    public const PROD_PACKAGE = 'PKG';

    public const PROD_PAIR = 'PR';

    public const PROD_PAIRS = 'PRS';

    public const PROD_ROLL = 'RL';

    public const PROD_SQUARE_METERS = 'SME';

    public const PROD_SQUARE_YARDS = 'SYD';

    public const PROD_TUBE = 'TU';

    public const PROD_YARD = 'YD';

    public const PROD_OTHER = 'OTH';

    protected function booted(): void
    {
        $this->code = self::LBS;
    }
}
