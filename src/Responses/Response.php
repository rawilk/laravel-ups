<?php

declare(strict_types=1);

namespace Rawilk\Ups\Responses;

use SimpleXMLElement;

class Response
{
    protected string $rawText = '';

    public function __construct(protected SimpleXMLElement $responseXml)
    {
    }

    public static function fromXml(SimpleXMLElement $responseXml): self
    {
        return new static($responseXml);
    }

    public function withText(string $text): self
    {
        $this->rawText = $text;

        return $this;
    }

    public function response(): SimpleXMLElement
    {
        return $this->responseXml;
    }

    public function text(): string
    {
        return $this->rawText;
    }
}
