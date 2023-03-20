<?php

namespace Rawilk\Ups\Concerns;

/**
 * @mixin \Rawilk\Ups\Entity\Entity
 *
 * @property array $response
 * @property null|string $error_code
 * @property null|string $error_description
 */
trait HandlesApiFailures
{
    /**
     * The code returned from the api when the request failed.
     */
    protected static string $failureCode = '0';

    public function failed(): bool
    {
        if ($this->response['response_status_code'] === static::$failureCode) {
            return true;
        }

        if (isset($this->response['error']) && ! empty($this->response['error'])) {
            return true;
        }

        if (method_exists($this, 'onFailed') && $this->onFailed()) {
            return true;
        }

        return false;
    }

    public function getErrorCodeAttribute(): ?string
    {
        if (! isset($this->response['error'])) {
            return null;
        }

        return $this->response['error']['error_code'] ?? '0';
    }

    public function getErrorDescriptionAttribute(): ?string
    {
        if (! isset($this->response['error'])) {
            return null;
        }

        return $this->response['error']['error_description'] ?? 'Unknown Error';
    }
}
