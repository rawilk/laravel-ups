<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Apis;

use Rawilk\Ups\Apis\Api;
use Rawilk\Ups\Requests\Request;
use Rawilk\Ups\Responses\Response;

class TestApi extends Api
{
    /** @var string */
    protected const ENDPOINT = '/Locator';

    public function sendRequest(): Response
    {
        return (new Request)
            ->to($this->endpoint(self::ENDPOINT))
            ->withAuthentication($this->createAccessRequestElement())
            ->withBody($this->getRequestElement())
            ->send();
    }

    public function requestWithNoEndpoint(): void
    {
        // an exception should be thrown here
        (new Request)->send();
    }

    protected function generateRequestXml(): void
    {
        // not called in our tests
    }

    protected function getRequestElement(): string
    {
        return file_get_contents(__DIR__ . '/../fixtures/xml/sample-locator-request.xml');
    }

    protected function requestUri(): string
    {
        // not called in our tests
        return '';
    }
}
