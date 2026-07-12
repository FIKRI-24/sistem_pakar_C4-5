<?php

namespace Tests\Unit\Services;

use App\Services\C45Client;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class C45ClientTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config()->set('services.c45.base_url', 'http://127.0.0.1:8001');
        config()->set('services.c45.timeout', 5);
        config()->set('services.c45.connect_timeout', 2);
        Http::preventStrayRequests();
    }

    public function test_health_returns_the_service_payload(): void
    {
        Http::fake([
            'http://127.0.0.1:8001/health' => Http::response([
                'status' => 'ok',
                'service' => 'c45-service',
                'version' => '0.1.0',
                'environment' => 'testing',
            ]),
        ]);

        $payload = app(C45Client::class)->health();

        $this->assertSame('ok', $payload['status']);
        $this->assertSame('c45-service', $payload['service']);
        Http::assertSent(fn ($request) => $request->method() === 'GET'
            && $request->url() === 'http://127.0.0.1:8001/health'
            && $request->hasHeader('Accept', 'application/json'));
    }

    public function test_health_throws_for_an_unavailable_service_response(): void
    {
        Http::fake([
            'http://127.0.0.1:8001/health' => Http::response([
                'detail' => 'Service unavailable',
            ], 503),
        ]);

        $this->expectException(RequestException::class);

        app(C45Client::class)->health();
    }
}
