<?php

namespace Vendor\ShopPackage\Tests\Unit;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Vendor\ShopPackage\Http\Middleware\CheckApiVersion;
use Vendor\ShopPackage\Tests\TestCase;

class CheckApiVersionTest extends TestCase
{
    private CheckApiVersion $middleware;

    protected function setUp(): void
    {
        parent::setUp();
        $this->middleware = new CheckApiVersion();
    }

    private function makeRequest(array $headers = []): Request
    {
        $request = Request::create('/test', 'GET');
        foreach ($headers as $key => $value) {
            $request->headers->set($key, $value);
        }
        return $request;
    }

    /** @test */
    public function it_rejects_request_without_api_version_header(): void
    {
        $request  = $this->makeRequest();
        $response = $this->middleware->handle($request, fn() => new Response('OK'));

        $body = json_decode($response->getContent(), true);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertArrayHasKey('error', $body);
    }

    /** @test */
    public function it_rejects_non_numeric_api_version(): void
    {
        $request  = $this->makeRequest(['X-API-VERSION' => 'abc']);
        $response = $this->middleware->handle($request, fn() => new Response('OK'));

        $this->assertEquals(400, $response->getStatusCode());
        $body = json_decode($response->getContent(), true);
        $this->assertStringContainsString('числовое', $body['error']);
    }

    /** @test */
    public function it_rejects_wrong_version_number(): void
    {
        config(['shop.api_version' => 1]);

        $request  = $this->makeRequest(['X-API-VERSION' => '2']);
        $response = $this->middleware->handle($request, fn() => new Response('OK'));

        $this->assertEquals(400, $response->getStatusCode());
    }

    /** @test */
    public function it_passes_correct_version_from_config(): void
    {
        config(['shop.api_version' => 1]);

        $request  = $this->makeRequest(['X-API-VERSION' => '1']);
        $response = $this->middleware->handle($request, fn() => new Response('OK'));

        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function it_passes_correct_version_from_parameter(): void
    {
        $request  = $this->makeRequest(['X-API-VERSION' => '3']);
        $response = $this->middleware->handle($request, fn() => new Response('OK'), '3');

        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function route_level_version_overrides_config(): void
    {
        config(['shop.api_version' => 1]);

        // Конфиг говорит 1, но маршрут требует 2 — должен пройти только '2'
        $requestOk   = $this->makeRequest(['X-API-VERSION' => '2']);
        $requestFail = $this->makeRequest(['X-API-VERSION' => '1']);

        $pass = $this->middleware->handle($requestOk,   fn() => new Response('OK'), '2');
        $fail = $this->middleware->handle($requestFail, fn() => new Response('OK'), '2');

        $this->assertEquals(200, $pass->getStatusCode());
        $this->assertEquals(400, $fail->getStatusCode());
    }
}
