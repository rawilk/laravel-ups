<?php

declare(strict_types=1);

use Rawilk\Ups\Exceptions\InvalidRequest;
use Rawilk\Ups\Exceptions\RequestFailed;
use Rawilk\Ups\Tests\Apis\TestApi;

it('can send requests to the ups api', function () {
    $response = (new TestApi)
        ->sendRequest();

    expect(isset($response->response()->SearchResults))->toBeTrue()
        ->and($response->text())->not()->toBeEmpty();
});

it('requires an endpoint to send', function () {
    (new TestApi)->requestWithNoEndpoint();
})->expectException(InvalidRequest::class);

it('requires authentication to send a request', function () {
    (new TestApi)
        ->usingAccessKey('')
        ->usingUserId('')
        ->usingPassword('')
        ->sendRequest();
})->expectException(InvalidRequest::class);

it('throws an exception for an invalid access key', function () {
    (new TestApi)
        ->usingAccessKey('invalid')
        ->sendRequest();
})->expectException(RequestFailed::class);
