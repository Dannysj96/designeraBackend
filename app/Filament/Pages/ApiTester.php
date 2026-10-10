<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class ApiTester extends Page
{
    protected string $view = 'filament.pages.api-tester';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-command-line';

    protected static ?string $navigationLabel = 'API Tester';

    protected static ?string $title = 'API Console & Tester';

    protected static ?int $navigationSort = 18;

    // Request properties
    public string $method = 'GET';
    public string $endpoint = '/api/v1/health';
    public array $headers = [
        ['key' => 'Accept', 'value' => 'application/json', 'enabled' => true],
        ['key' => 'Content-Type', 'value' => 'application/json', 'enabled' => true],
    ];
    public array $params = [];
    public string $body = '';
    public string $bearerToken = '';
    public string $activeTab = 'params';
    public string $search = '';

    // Response properties
    public ?string $responseBody = null;
    public ?int $responseStatus = null;
    public ?string $responseStatusText = null;
    public ?float $responseTime = null;
    public ?string $responseSize = null;
    public array $responseHeaders = [];

    // History
    public array $history = [];

    public function mount(): void
    {
        $this->history = session()->get('api_tester_history', []);
        $this->sendRequest();
    }

    public function getDiscoveredRoutesProperty(): array
    {
        $routes = Route::getRoutes();
        $apiRoutes = [];

        foreach ($routes as $route) {
            $uri = $route->uri();
            if (str_starts_with($uri, 'api/')) {
                $methods = array_diff($route->methods(), ['HEAD']);
                foreach ($methods as $m) {
                    $formattedUri = '/' . ltrim($uri, '/');
                    if (empty($this->search) || 
                        str_contains(strtolower($formattedUri), strtolower($this->search)) ||
                        str_contains(strtolower($m), strtolower($this->search))) {
                        $apiRoutes[] = [
                            'method' => $m,
                            'uri' => $formattedUri,
                            'name' => $route->getName() ?: $formattedUri,
                        ];
                    }
                }
            }
        }

        // Sort by URI then method
        usort($apiRoutes, fn($a, $b) => strcmp($a['uri'], $b['uri']));

        return $apiRoutes;
    }

    public function selectEndpoint(string $uri, string $method): void
    {
        $this->method = strtoupper($method);
        $this->endpoint = $uri;
        
        // Setup smart defaults based on endpoint
        if ($this->method === 'GET') {
            $this->activeTab = 'params';
            if ($uri === '/api/v1/locations/cities') {
                $this->params = [
                    ['key' => 'state_id', 'value' => '21', 'enabled' => true],
                ];
            } elseif (str_contains($uri, '{id}')) {
                $this->endpoint = str_replace('{id}', '1', $uri);
                $this->params = [];
            } elseif ($uri === '/api/v1/parent-categories') {
                $this->params = [
                    ['key' => 'with_categories', 'value' => '1', 'enabled' => true],
                ];
            } elseif ($uri === '/api/v1/designs') {
                $this->params = [
                    ['key' => 'day', 'value' => 'today', 'enabled' => true],
                ];
            } else {
                $this->params = [];
            }
        } else {
            $this->activeTab = 'body';
            if ($uri === '/api/v1/auth/login') {
                $this->body = json_encode([
                    'login' => 'facta@gmail.com',
                    'password' => 'secret123',
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            } elseif ($uri === '/api/v1/auth/register') {
                $this->body = json_encode([
                    'name' => 'Test User',
                    'email' => 'test_' . time() . '@example.com',
                    'mobile' => '98765' . rand(10000, 99999),
                    'password' => 'secret123',
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            } elseif ($uri === '/api/v1/auth/otp-login') {
                $this->body = json_encode([
                    'mobile' => '8208220580',
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            } elseif ($uri === '/api/v1/coupons/validate') {
                $this->body = json_encode([
                    'code' => 'DISCOUNT50',
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            } elseif (empty($this->body) || $this->body === "{\n  \n}") {
                $this->body = "{\n  \n}";
            }
        }

        $this->sendRequest();
    }

    public function addHeader(): void
    {
        $this->headers[] = ['key' => '', 'value' => '', 'enabled' => true];
    }

    public function removeHeader(int $index): void
    {
        unset($this->headers[$index]);
        $this->headers = array_values($this->headers);
    }

    public function addParam(): void
    {
        $this->params[] = ['key' => '', 'value' => '', 'enabled' => true];
    }

    public function removeParam(int $index): void
    {
        unset($this->params[$index]);
        $this->params = array_values($this->params);
    }

    public function prettifyJson(): void
    {
        if (empty($this->body)) {
            return;
        }

        $decoded = json_decode($this->body, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $this->body = json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
    }

    public function sendRequest(): void
    {
        $targetUrl = trim($this->endpoint);

        // If not full URL, construct full URL using url()
        if (! str_starts_with($targetUrl, 'http://') && ! str_starts_with($targetUrl, 'https://')) {
            if (str_starts_with($targetUrl, '/admin2/')) {
                $targetUrl = substr($targetUrl, 7);
            }
            $targetUrl = url('/' . ltrim($targetUrl, '/'));
        }

        // Parse query parameters
        $queryParams = [];
        $parsedUrl = parse_url($targetUrl);
        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $queryParams);
        }

        foreach ($this->params as $param) {
            if (!empty($param['key']) && ($param['enabled'] ?? true)) {
                $queryParams[$param['key']] = $param['value'] ?? '';
            }
        }

        // Build headers
        $requestHeaders = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'ngrok-skip-browser-warning' => '1',
        ];

        foreach ($this->headers as $header) {
            if (!empty($header['key']) && ($header['enabled'] ?? true)) {
                $requestHeaders[$header['key']] = $header['value'];
            }
        }

        if (!empty($this->bearerToken)) {
            $requestHeaders['Authorization'] = 'Bearer ' . trim($this->bearerToken);
        }

        $method = strtoupper($this->method);
        $startTime = microtime(true);

        try {
            $httpClient = Http::withoutVerifying()
                ->timeout(20)
                ->withHeaders($requestHeaders);

            $cleanUrl = strtok($targetUrl, '?');

            if (in_array($method, ['POST', 'PUT', 'PATCH', 'DELETE'])) {
                $payload = [];
                if (!empty($this->body)) {
                    $decoded = json_decode($this->body, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        $payload = $decoded;
                    }
                }
                
                if (!empty($queryParams)) {
                    $cleanUrl .= '?' . http_build_query($queryParams);
                }

                $response = match ($method) {
                    'POST' => !empty($payload) ? $httpClient->post($cleanUrl, $payload) : $httpClient->withBody($this->body, 'application/json')->post($cleanUrl),
                    'PUT' => !empty($payload) ? $httpClient->put($cleanUrl, $payload) : $httpClient->withBody($this->body, 'application/json')->put($cleanUrl),
                    'PATCH' => !empty($payload) ? $httpClient->patch($cleanUrl, $payload) : $httpClient->withBody($this->body, 'application/json')->patch($cleanUrl),
                    'DELETE' => $httpClient->delete($cleanUrl, $payload),
                };
            } else {
                $response = $httpClient->get($cleanUrl, $queryParams);
            }

            $endTime = microtime(true);
            $this->responseTime = round(($endTime - $startTime) * 1000, 1);
            $this->responseStatus = $response->status();
            $this->responseStatusText = Response::$statusTexts[$this->responseStatus] ?? 'OK';

            $rawContent = $response->body();
            $rawLen = strlen($rawContent);
            $this->responseSize = $rawLen > 1024 ? round($rawLen / 1024, 2) . ' KB' : $rawLen . ' B';

            // Extract token automatically if user logged in
            $json = json_decode($rawContent, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                if (isset($json['token']) && empty($this->bearerToken)) {
                    $this->bearerToken = $json['token'];
                }
                $this->responseBody = json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            } else {
                $this->responseBody = $rawContent;
            }

            // Response headers
            $headersList = [];
            foreach ($response->headers() as $name => $values) {
                $headersList[$name] = is_array($values) ? implode(', ', $values) : (string) $values;
            }
            $this->responseHeaders = $headersList;

            // Save to history (keep max 10)
            array_unshift($this->history, [
                'method' => $method,
                'endpoint' => $this->endpoint,
                'status' => $this->responseStatus,
                'time' => $this->responseTime . 'ms',
                'timestamp' => now()->format('H:i:s'),
            ]);
            $this->history = array_slice($this->history, 0, 10);
            session()->put('api_tester_history', $this->history);

        } catch (\Throwable $e) {
            $this->responseStatus = 500;
            $this->responseStatusText = 'Request Error';
            $this->responseTime = 0;
            $this->responseSize = '0 B';
            $this->responseHeaders = [];
            $this->responseBody = json_encode([
                'error' => true,
                'message' => $e->getMessage(),
                'target_url' => $targetUrl,
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
    }

    public function clearHistory(): void
    {
        $this->history = [];
        session()->forget('api_tester_history');
    }
}
