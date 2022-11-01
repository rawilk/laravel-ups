<?php

declare(strict_types=1);

namespace Rawilk\Ups\Apis\AddressValidation;

use Rawilk\Ups\Apis\Api;
use Rawilk\Ups\Entity\Address\Address;
use Rawilk\Ups\Exceptions\BadRequest;
use Rawilk\Ups\Responses\AddressValidation\AddressValidationResponse;
use SimpleXMLElement;

class AddressValidation extends Api
{
    /** @var string */
    protected const ENDPOINT = '/XAV';

    /** @var int */
    protected const MAX_ALLOWED_SUGGESTIONS = 50;

    protected int $maxSuggestions;

    protected int $requestOption = AddressValidationOption::ADDRESS_VALIDATION;

    protected null|Address $address = null;

    protected static array $supportedCountries = ['US', 'PR'];

    public function validate(Address $address = null): AddressValidationResponse
    {
        // The UPS Customer Integration Environment (sandbox = true) only allows certain states to be
        // validated, so we will always use the production api instead since it's free anyways.
        $this->inProductionMode();

        if ($address) {
            $this->address = $address;
        }

        $this->guardAgainstInvalidAddress();

        return AddressValidationResponse::fromXml($this->processRequest()->response())
            ->usingRequestOption($this->requestOption);
    }

    public function maxSuggestions(int $max): self
    {
        $this->guardAgainstInvalidMaxSuggestions($max);

        $this->maxSuggestions = $max;

        return $this;
    }

    public function usingRequestOption(int $option): self
    {
        $this->guardAgainstInvalidRequestOption($option);

        $this->requestOption = $option;

        return $this;
    }

    public function usingAddress(Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    protected function generateRequestXml(): string
    {
        $xml = new SimpleXMLElement('<AddressValidationRequest/>');

        $request = $xml->addChild('Request');
        $this->appendTransactionReference($request);
        $request->addChild('RequestAction', 'XAV');
        $request->addChild('RequestOption', (string) $this->requestOption);

        if (isset($this->maxSuggestions)) {
            $xml->addChild('MaximumListSize', (string) $this->maxSuggestions);
        }

        $this->generateAddressElement($xml);

        return (string) $xml->asXML();
    }

    protected function generateAddressElement(SimpleXMLElement $parent): void
    {
        $xml = $parent->addChild('AddressKeyFormat');

        $this
            ->address
            ->isForValidation()
            ->toSimpleXml($xml, false);
    }

    protected function guardAgainstInvalidMaxSuggestions(int $max): void
    {
        if ($max < 1) {
            throw BadRequest::minSuggestionsNotMet();
        }

        if ($max > self::MAX_ALLOWED_SUGGESTIONS) {
            throw BadRequest::maxSuggestionsExceeded(self::MAX_ALLOWED_SUGGESTIONS);
        }
    }

    protected function guardAgainstInvalidRequestOption(int $option): void
    {
        if (! in_array($option, range(1, 3), true)) {
            throw BadRequest::invalidRequestOption();
        }
    }

    protected function guardAgainstInvalidAddress(): void
    {
        if (! $this->address) {
            throw BadRequest::missingRequiredData('Address is required.');
        }

        if (! isset($this->address->country_code) || empty($this->address->country_code)) {
            throw BadRequest::missingRequiredData('Country code is required.');
        }

        if (! static::isSupportedCountry($this->address->country_code)) {
            throw BadRequest::invalidData("Country code '{$this->address->country_code}' is not supported for address validation.");
        }
    }

    public static function isSupportedCountry(string $countryCode): bool
    {
        return in_array(strtoupper($countryCode), static::$supportedCountries, true);
    }

    /*
     * Convenience methods for request options.
     */

    public function classificationAndValidation(): self
    {
        $this->requestOption = AddressValidationOption::ADDRESS_VALIDATION_AND_CLASSIFICATION;

        return $this;
    }

    public function validationOnly(): self
    {
        $this->requestOption = AddressValidationOption::ADDRESS_VALIDATION;

        return $this;
    }

    public function classificationOnly(): self
    {
        $this->requestOption = AddressValidationOption::ADDRESS_CLASSIFICATION;

        return $this;
    }
}
