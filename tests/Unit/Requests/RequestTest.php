<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Requests;

use Rawilk\Ups\Exceptions\InvalidRequest;
use Rawilk\Ups\Exceptions\RequestFailed;
use Rawilk\Ups\Tests\Apis\TestApi;
use Rawilk\Ups\Tests\TestCase;

class RequestTest extends TestCase
{
    /** @test */
    public function can_send_requests_to_the_ups_api(): void
    {
        $response = (new TestApi)
            ->sendRequest();

        self::assertTrue(isset($response->response()->SearchResults));
        self::assertNotEmpty($response->text());
    }

    /** @test */
    public function endpoint_is_required_to_send(): void
    {
        $this->expectException(InvalidRequest::class);

        (new TestApi)
            ->requestWithNoEndpoint();
    }

    /** @test */
    public function authentication_is_required_to_send(): void
    {
        $this->expectException(InvalidRequest::class);

        (new TestApi)
            ->usingAccessKey('')
            ->usingUserId('')
            ->usingPassword('')
            ->sendRequest();
    }

    /** @test */
    public function invalid_access_key_throws_exception(): void
    {
        $this->expectException(RequestFailed::class);

        (new TestApi)
            ->usingAccessKey('invalid')
            ->sendRequest();
    }
}
