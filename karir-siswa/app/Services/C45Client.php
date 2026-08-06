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

    /**
     * Train the C4.5 decision tree model.
     *
     * @param int $userId
     * @return array<string, mixed>
     */
    public function train(int $userId): array
    {
        $payload = $this->request()
            ->post('/train', [
                'dibuat_oleh' => $userId,
            ])
            ->throw()
            ->json();

        if (! is_array($payload)) {
            throw new UnexpectedValueException('The C4.5 train endpoint returned an invalid JSON response.');
        }

        return $payload;
    }

    /**
     * Classify student attributes.
     *
     * @param array{minat: string, bakat: string, nilai_akademik: float, kepribadian: string} $attributes
     * @return array{karir_id: int, nama_karir: string, persen_kecocokan: float, alasan: string}
     */
    public function classify(array $attributes): array
    {
        $payload = $this->request()
            ->post('/classify', $attributes)
            ->throw()
            ->json();

        if (! is_array($payload)) {
            throw new UnexpectedValueException('The C4.5 classify endpoint returned an invalid JSON response.');
        }

        return $payload;
    }

    /**
     * Get the latest active tree structure.
     *
     * @return array<string, mixed>
     */
    public function getLatestTree(): array
    {
        $payload = $this->request()
            ->get('/tree/latest')
            ->throw()
            ->json();

        if (! is_array($payload)) {
            throw new UnexpectedValueException('The C4.5 tree endpoint returned an invalid JSON response.');
        }

        return $payload;
    }

    /**
     * Get the extracted rules of the latest active tree.
     *
     * @return array<string, mixed>
     */
    public function getRules(): array
    {
        $payload = $this->request()
            ->get('/tree/rules')
            ->throw()
            ->json();

        if (! is_array($payload)) {
            throw new UnexpectedValueException('The C4.5 rules endpoint returned an invalid JSON response.');
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
