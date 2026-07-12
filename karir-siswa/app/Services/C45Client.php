<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;
use UnexpectedValueException;

class C45Client
{
    /**
     * Check whether the Python C4.5 service is available.
     *
     * @return array<string, mixed>
     */
    public function health(): array
    {
        $payload = $this->request()
            ->get('/health')
            ->throw()
            ->json();

        if (! is_array($payload)) {
            throw new UnexpectedValueException('The C4.5 health endpoint returned an invalid JSON response.');
        }

        return $payload;
    }

    private function request(): PendingRequest
    {
        $baseUrl = rtrim((string) config('services.c45.base_url'), '/');

        if ($baseUrl === '') {
            throw new InvalidArgumentException('C45_SERVICE_URL must be configured.');
        }

        return Http::baseUrl($baseUrl)
            ->acceptJson()
            ->connectTimeout((float) config('services.c45.connect_timeout', 2))
            ->timeout((float) config('services.c45.timeout', 5));
    }
}
