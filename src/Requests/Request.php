<?php

declare(strict_types=1);

namespace Rawilk\Ups\Requests;

use DateTime;
use Illuminate\Http\Client\Response as HttpResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Rawilk\Ups\Exceptions\InvalidRequest;
use Rawilk\Ups\Exceptions\RequestFailed;
use Rawilk\Ups\Responses\Response;
use SimpleXMLElement;

class Request
{
    /** @var int */
    protected const RESPONSE_CODE_OK = 1;

    /** @var int */
    protected const RESPONSE_CODE_ERROR = 0;

    protected string $accessXml = '';

    protected string $endpoint = '';

    protected string $requestXml = '';

    protected bool $throwExceptionOnError = true;

    public function send(): Response
    {
        $this->validateRequest();

        $date = (new DateTime)->format('YmdHisu');
        $this->logRequest($date);

        $response = Http::accept('UTF-8')
            ->withBody(
                $this->accessXml . $this->requestXml,
                'application/x-www-form-urlencoded'
            )
            ->post($this->endpoint);

        return $this->generateResponse($response, $date);
    }

    public function to(string $endpoint): self
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    public function withAuthentication(string $xml): self
    {
        $this->accessXml = $xml;

        return $this;
    }

    public function withBody(string $xml): self
    {
        $this->requestXml = $xml;

        return $this;
    }

    public function dontThrowExceptionOnError(): self
    {
        $this->throwExceptionOnError = false;

        return $this;
    }

    protected function generateResponse(HttpResponse $response, string $date): Response
    {
        $body = $response->body();

        $this->logResponse($date, $body);

        if (! $response->ok()) {
            throw RequestFailed::requestNotOk($response->status());
        }

        $xml = new SimpleXMLElement($this->convertEncoding($body));

        if (! isset($xml->Response, $xml->Response->ResponseStatusCode)) {
            throw RequestFailed::unexpectedFormat();
        }

        $responseCode = (int) $xml->Response->ResponseStatusCode;

        if (! $this->throwExceptionOnError || $responseCode === self::RESPONSE_CODE_OK) {
            return Response::fromXml($xml)->withText($body);
        }

        if ($responseCode === self::RESPONSE_CODE_ERROR) {
            throw RequestFailed::error((string) $xml->Response->Error->ErrorDescription, (int) $xml->Response->Error->ErrorCode);
        }

        throw RequestFailed::unexpectedFormat();
    }

    protected function convertEncoding(string $body): string
    {
        if (! function_exists('mb_convert_encoding')) {
            return $body;
        }

        $encoding = mb_detect_encoding($body);

        if ($encoding) {
            return mb_convert_encoding($body, 'UTF-8', $encoding);
        }

        return utf8_encode($body);
    }

    protected function logRequest(string $date): void
    {
        if (! $this->shouldLog()) {
            return;
        }

        Log::info('Request to UPS API', [
            'id' => $date,
            'endpoint' => $this->endpoint,
        ]);

        Log::debug("Request: {$this->requestXml}", [
            'id' => $date,
            'endpoint' => $this->endpoint,
        ]);
    }

    protected function logResponse(string $date, string $body): void
    {
        if (! $this->shouldLog()) {
            return;
        }

        Log::info('Response from UPS API', [
            'id' => $date,
            'endpoint' => $this->endpoint,
        ]);

        Log::debug("Response: {$body}", [
            'id' => $date,
            'endpoint' => $this->endpoint,
        ]);
    }

    protected function shouldLog(): bool
    {
        return config('ups.logging') === true;
    }

    protected function validateRequest(): void
    {
        if (empty($this->endpoint)) {
            throw InvalidRequest::missingEndpoint();
        }

        if (empty($this->accessXml)) {
            throw InvalidRequest::missingAuthentication();
        }

        if (Str::contains($this->accessXml, ['<AccessLicenseNumber/>', '<UserId/>', '<Password/>'])) {
            throw InvalidRequest::missingAuthentication();
        }
    }
}
