<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Apis\AddressValidation;

use Rawilk\Ups\Apis\AddressValidation\AddressValidation;
use Rawilk\Ups\Entity\Address\Address;
use Rawilk\Ups\Exceptions\BadRequest;
use Rawilk\Ups\Tests\TestCase;

class AddressValidationTest extends TestCase
{
    /** @test */
    public function can_make_requests(): void
    {
        // This address is provided in the samples in UPS developer documentation
        // and returns as ambiguous.
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

        self::assertTrue($response->ambiguous);
        self::assertTrue($response->candidates->count() > 0);
    }

    /** @test */
    public function address_is_required(): void
    {
        $this->expectException(BadRequest::class);

        (new AddressValidation)->validate();
    }

    /** @test */
    public function at_least_one_suggestion_must_be_requested(): void
    {
        $this->expectException(BadRequest::class);

        (new AddressValidation)->maxSuggestions(0);
    }

    /** @test */
    public function no_more_than_50_suggestions_are_allowed(): void
    {
        $this->expectException(BadRequest::class);

        (new AddressValidation)->maxSuggestions(51);
    }

    /**
     * @test
     * @dataProvider invalidRequestOptions
     * @param int $option
     */
    public function invalid_request_options_are_not_allowed(int $option): void
    {
        $this->expectException(BadRequest::class);

        (new AddressValidation)->usingRequestOption($option);
    }

    public function invalidRequestOptions(): array
    {
        return [
            [-1],
            [0],
            [4],
        ];
    }
}
