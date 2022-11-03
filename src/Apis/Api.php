<?php

declare(strict_types=1);

namespace Rawilk\Ups\Apis;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Rawilk\Ups\Requests\Request;
use Rawilk\Ups\Responses\Response;
use SimpleXMLElement;

abstract class Api
{
    /** @var string */
    protected const PRODUCTION_BASE_URI = 'https://onlinetools.ups.com/ups.app/xml';

    /** @var string */
    protected const SANDBOX_BASE_URI = 'https://wwwcie.ups.com/ups.app/xml';

    /**
     * This should be overridden in the concrete api implementations.
     *
     * @var string
     */
    protected const ENDPOINT = '/';

    protected string $accessKey;

    protected string $userId;

    protected string $password;

    protected bool $sandbox;

    protected string $context = '';

    protected ?Request $request = null;

    protected bool $allowRequestErrors = false;

    public function __construct()
    {
        $config = Config::get('ups', []);

        $this->accessKey = $config['access_key'];
        $this->userId = $config['user_id'];
        $this->password = $config['password'];
        $this->sandbox = $config['sandbox'];
    }

    abstract protected function generateRequestXml();

    protected function requestUri(): string
    {
        return $this->endpoint(static::ENDPOINT);
    }

    public function usingAccessKey(string $accessKey): self
    {
        $this->accessKey = $accessKey;

        return $this;
    }

    public function usingUserId(string $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function usingPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function inSandboxMode(): self
    {
        $this->sandbox = true;

        return $this;
    }

    public function inProductionMode(): self
    {
        $this->sandbox = false;

        return $this;
    }

    public function withCustomerContext(string $context): self
    {
        $this->context = $context;

        return $this;
    }

    public function allowRequestErrors(): self
    {
        $this->allowRequestErrors = true;

        return $this;
    }

    protected function baseUri(): string
    {
        return $this->sandbox ? self::SANDBOX_BASE_URI : self::PRODUCTION_BASE_URI;
    }

    protected function endpoint(string $endpoint): string
    {
        if (! Str::startsWith($endpoint, '/')) {
            $endpoint = "/{$endpoint}";
        }

        return $this->baseUri() . $endpoint;
    }

    protected function getRequest(): Request
    {
        if (! $this->request) {
            $this->request = new Request;
        }

        return $this->request;
    }

    protected function createAccessRequestElement(): string
    {
        $xml = new SimpleXMLElement('<AccessRequest/>');

        $xml->addChild('AccessLicenseNumber', $this->accessKey);
        $xml->addChild('UserId', $this->userId);
        $xml->addChild('Password', $this->password);

        return (string) $xml->asXML();
    }

    protected function appendTransactionReference(SimpleXMLElement $parent): void
    {
        if (! $this->context) {
            return;
        }

        $xml = $parent->addChild('TransactionReference');

        $xml->addChild('CustomerContext', $this->context);
        $xml->addChild('XcpiVersion', '1.0');
    }

    protected function processRequest(): Response
    {
        $request = $this
            ->getRequest()
            ->to($this->requestUri())
            ->withAuthentication($this->createAccessRequestElement())
            ->withBody($this->generateRequestXml());

        if ($this->allowRequestErrors) {
            $request->dontThrowExceptionOnError();
        }

        return $request->send();
    }
}
