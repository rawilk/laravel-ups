<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Location;

use Illuminate\Support\Collection;
use Rawilk\Ups\Entity\Address\AddressKeyFormat;
use Rawilk\Ups\Entity\Entity;

/**
 * @property string $location_id
 *      The Location ID that corresponds to the UPS location. Do not expose the Location ID.
 * @property string $origin_or_destination
 *      Will be returned for FreightWillCallRequestType 1 Postal based and 3 City and/or State based search.
 *      OriginOrDestination will be 01 for origin facilities and 02 for Destination facilities.
 * @property null|string $phone_number
 * @property null|string $fax_number
 * @property null|string $email
 *      Email address of the UPS location. Returned when available.
 * @property null|string $latest_ground_drop_off_time
 * @property null|string $latest_air_drop_off_time
 * @property bool $additional_charge
 * @property null|string $standard_hours_of_operation
 * @property null|string $non_standard_hours_of_operation
 * @property null|string $will_call_hours_of_operation
 * @property null|string $number
 *      The center number of the drop location if it is The UPS store.
 * @property null|string $home_page_url
 *      The home page URL of the drop location if it is The UPS store.
 * @property null|string $comments
 * @property null|string $disclaimer
 * @property null|string $slic
 * @property null|string $timezone
 * @property null|string $facility_type PKG/FRT
 * @property \Illuminate\Support\Collection|\Rawilk\Ups\Entity\Location\ServiceOffering[] $service_offerings
 * @property bool $display_phone_number
 * @property bool $location_new
 * @property bool $will_call_location
 * @property null|\Rawilk\Ups\Entity\Location\Geocode $geocode
 * @property null|\Rawilk\Ups\Entity\Location\IVR $ivr Integrated Voice Response Information. Only for IVR.
 * @property \Rawilk\Ups\Entity\Address\AddressKeyFormat $address
 * @property \Rawilk\Ups\Entity\Location\LocationAttribute $location_attribute
 * @property \Rawilk\Ups\Entity\Location\OperatingHours $operating_hours
 * @property \Rawilk\Ups\Entity\Location\AccessPointInformation $access_point_information
 * @property \Rawilk\Ups\Entity\Location\Distance $distance
 *      The straight line distance from the origin to the UPS location.
 */
class DropLocation extends Entity
{
    /** @var string */
    protected const ORIGIN_FACILITY_CODE = '01';

    /** @var string */
    protected const DESTINATION_FACILITY_CODE = '02';

    protected array $attributeKeyMap = [
        'address_key_format' => 'address',
        'e_mail_address' => 'email',
        'additional_charge_indicator' => 'additional_charge',
        'service_offering_list' => 'service_offerings',
        'display_phone_number_indicator' => 'display_phone_number',
        'location_new_indicator' => 'location_new',
        'will_call_location_indicator' => 'will_call_location',
    ];

    protected $casts = [
        'additional_charge' => 'boolean',
        'location_new' => 'boolean',
        'will_call_location' => 'boolean',
    ];

    public function addressKeyFormat(): string
    {
        return AddressKeyFormat::class;
    }

    public function distance(): string
    {
        return Distance::class;
    }

    public function geocode(): string
    {
        return Geocode::class;
    }

    public function ivr(): string
    {
        return IVR::class;
    }

    public function locationAttribute(): string
    {
        return LocationAttribute::class;
    }

    public function operatingHours(): string
    {
        return OperatingHours::class;
    }

    public function accessPointInformation(): string
    {
        return AccessPointInformation::class;
    }

    public function getLocationNewAttribute($value): bool
    {
        return strtolower($value) === 'y';
    }

    public function getWillCallLocationAttribute($value): bool
    {
        return strtolower($value) === 'y';
    }

    public function getDisplayPhoneNumberAttribute($value): bool
    {
        return (string) $value === '1';
    }

    public function getServiceOfferingsAttribute($serviceOfferings): Collection
    {
        return is_null($serviceOfferings)
            ? collect()
            : $serviceOfferings;
    }

    public function setServiceOfferingsAttribute($value): void
    {
        if (! is_array($value) || ! isset($value['service_offering'])) {
            $this->attributes['service_offerings'] = collect();

            return;
        }

        $this->attributes['service_offerings'] = collect($value['service_offering'])
            ->map(fn (array $data) => new ServiceOffering($data));
    }

    public function isOriginFacility(): bool
    {
        return $this->origin_or_destination === self::ORIGIN_FACILITY_CODE;
    }

    public function isDestinationFacility(): bool
    {
        return $this->origin_or_destination === self::DESTINATION_FACILITY_CODE;
    }
}
