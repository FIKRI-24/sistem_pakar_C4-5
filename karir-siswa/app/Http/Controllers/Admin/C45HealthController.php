<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\C45Client;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\View\View;
use Throwable;

class C45HealthController extends Controller
{
    public function __invoke(C45Client $client): View
    {
        $startedAt = hrtime(true);
        $payload = [];
        $isHealthy = false;
        $message = 'Service C4.5 tidak dapat dihubungi. Pastikan service Python sedang berjalan.';

        try {
            $payload = $client->health();
            $isHealthy = ($payload['status'] ?? null) === 'ok';
            $message = $isHealthy
                ? 'Service C4.5 merespons dengan baik dan siap digunakan.'
                : 'Service C4.5 merespons, tetapi melaporkan status yang tidak sehat.';
        } catch (ConnectionException) {
            // The friendly default message is enough for an expected local outage.
        } catch (RequestException $exception) {
            $status = $exception->response->status();
            $message = "Service C4.5 mengembalikan respons HTTP {$status}.";
        } catch (Throwable) {
            $message = 'Status service C4.5 tidak dapat dibaca. Periksa konfigurasi dan format respons service.';
        }

        return view('admin.c45-status', [
            'isHealthy' => $isHealthy,
            'message' => $message,
            'endpoint' => rtrim((string) config('services.c45.base_url'), '/').'/health',
            'responseTimeMs' => round((hrtime(true) - $startedAt) / 1_000_000, 1),
            'checkedAt' => now(),
            'service' => $payload['service'] ?? null,
            'version' => $payload['version'] ?? null,
            'environment' => $payload['environment'] ?? null,
        ]);
    }
}
