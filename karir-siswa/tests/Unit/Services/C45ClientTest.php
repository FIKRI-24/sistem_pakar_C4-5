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

    public function test_train_sends_user_id_and_returns_payload(): void
    {
        Http::fake([
            'http://127.0.0.1:8001/train' => Http::response([
                'status' => 'success',
                'versi' => 2,
                'akurasi' => 0.85,
            ]),
        ]);

        $payload = app(C45Client::class)->train(42);

        $this->assertSame('success', $payload['status']);
        $this->assertSame(2, $payload['versi']);
        $this->assertSame(0.85, $payload['akurasi']);

        Http::assertSent(fn ($request) => $request->method() === 'POST'
            && $request->url() === 'http://127.0.0.1:8001/train'
            && $request['dibuat_oleh'] === 42);
    }

    public function test_classify_sends_attributes_and_returns_recommendation(): void
    {
        $attributes = [
            'minat' => 'Investigative',
            'bakat' => 'Numerik/Logika',
            'nilai_akademik' => 85.5,
            'kepribadian' => 'Compliance',
        ];

        Http::fake([
            'http://127.0.0.1:8001/classify' => Http::response([
                'karir_id' => 3,
                'nama_karir' => 'Software Engineer',
                'persen_kecocokan' => 90.0,
                'alasan' => 'Minat = Investigative AND Nilai Akademik > 80.0',
            ]),
        ]);

        $payload = app(C45Client::class)->classify($attributes);

        $this->assertSame(3, $payload['karir_id']);
        $this->assertSame('Software Engineer', $payload['nama_karir']);
        $this->assertEquals(90.0, $payload['persen_kecocokan']);
        $this->assertSame('Minat = Investigative AND Nilai Akademik > 80.0', $payload['alasan']);

        Http::assertSent(fn ($request) => $request->method() === 'POST'
            && $request->url() === 'http://127.0.0.1:8001/classify'
            && $request->data() === $attributes);
    }

    public function test_get_latest_tree_returns_tree_json(): void
    {
        Http::fake([
            'http://127.0.0.1:8001/tree/latest' => Http::response([
                'versi' => 1,
                'akurasi' => 0.95,
                'tree' => ['type' => 'leaf', 'class' => 3],
            ]),
        ]);

        $payload = app(C45Client::class)->getLatestTree();

        $this->assertSame(1, $payload['versi']);
        $this->assertSame(0.95, $payload['akurasi']);
        $this->assertSame(['type' => 'leaf', 'class' => 3], $payload['tree']);

        Http::assertSent(fn ($request) => $request->method() === 'GET'
            && $request->url() === 'http://127.0.0.1:8001/tree/latest');
    }

    public function test_get_rules_returns_tree_rules(): void
    {
        Http::fake([
            'http://127.0.0.1:8001/tree/rules' => Http::response([
                'versi' => 1,
                'akurasi' => 0.95,
                'rules' => [
                    ['rule' => 'IF minat = Investigative THEN Software Engineer', 'career_id' => 3],
                ],
            ]),
        ]);

        $payload = app(C45Client::class)->getRules();

        $this->assertSame(1, $payload['versi']);
        $this->assertSame(0.95, $payload['akurasi']);
        $this->assertSame('IF minat = Investigative THEN Software Engineer', $payload['rules'][0]['rule']);

        Http::assertSent(fn ($request) => $request->method() === 'GET'
            && $request->url() === 'http://127.0.0.1:8001/tree/rules');
    }
}
