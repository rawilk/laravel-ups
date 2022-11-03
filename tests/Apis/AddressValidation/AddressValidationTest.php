<?php

declare(strict_types=1);

use Rawilk\Ups\Apis\AddressValidation\AddressValidation;
use Rawilk\Ups\Entity\Address\Address;
use Rawilk\Ups\Exceptions\BadRequest;

it('can make requests', function () {
    /*
     * This address is provided in the samples in UPS developer documentation
     * and returns as ambiguous.
     *
     * Note: As of 2/22/2021, I can't seem to locate this example in the
     * docs anymore, and now the api is returning the no candidates
     * indicator instead.
     */
    $address = new Address([
        'address_line1' => 'AIRWAY ROAD SUITE 7',
        'city' => 'San Diego',
        'state' => 'CA',
        'postal_code' => '92154',
        'country_code' => 'US',
    ]);

    $response = (new AddressValidation)
        ->usingAddress($address)
        ->maxSuggestions(3)
        ->validate();

    expect($response->no_candidates)->toBeTrue()
        ->and($response->candidates)->toHaveCount(0);
});

it('requires address', function () {
    (new AddressValidation)->validate();
})->expectException(BadRequest::class);

it('requires at least one suggestion to be requested', function () {
    (new AddressValidation)->maxSuggestions(0);
})->expectException(BadRequest::class);

it('does not allow more than 50 suggestions', function () {
    (new AddressValidation)->maxSuggestions(51);
})->expectException(BadRequest::class);

it('does not allow invalid request options', function (int $option) {
    (new AddressValidation)->usingRequestOption($option);
})->with('invalidRequestOptions')->expectException(BadRequest::class);

dataset('invalidRequestOptions', [
    -1,
    0,
    4,
]);
