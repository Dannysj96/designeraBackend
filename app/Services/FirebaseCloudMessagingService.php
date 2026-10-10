<?php

namespace App\Services;

use App\Models\RegularNotification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class FirebaseCloudMessagingService
{
    private const OAUTH_TOKEN_URL = 'https://oauth2.googleapis.com/token';

    private const FCM_SCOPE = 'https://www.googleapis.com/auth/firebase.messaging';

    public function sendRegularNotification(RegularNotification $notification): string
    {
        $credentials = $this->getCredentials();
        $projectId = $credentials['project_id'] ?? null;

        if (! is_string($projectId) || $projectId === '') {
            throw new RuntimeException('Firebase service account is missing its project_id.');
        }

        $message = [
            'topic' => $notification->firebase_topic,
            'notification' => [
                'title' => $notification->title,
                'body' => $notification->message ?? '',
            ],
            'data' => [
                'notification_id' => (string) $notification->getKey(),
                'notification_type' => (string) ($notification->notification_type ?? ''),
                'sub_type' => (string) ($notification->sub_type ?? ''),
                'image' => (string) ($notification->image_url ?? ''),
                'video' => (string) ($notification->video_url ?? ''),
            ],
            'android' => [
                'priority' => 'HIGH',
            ],
        ];

        if ($notification->image_url) {
            $message['notification']['image'] = $notification->image_url;
        }

        $response = Http::withToken($this->getAccessToken($credentials))
            ->acceptJson()
            ->timeout(20)
            ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", [
                'message' => $message,
            ]);

        if ($response->failed()) {
            throw new RuntimeException('Firebase rejected the notification: '.$response->json('error.message', 'Unknown FCM error.'));
        }

        $messageId = $response->json('name');

        if (! is_string($messageId) || $messageId === '') {
            throw new RuntimeException('Firebase accepted no message identifier for the notification.');
        }

        return $messageId;
    }

    /**
     * @return array{project_id?: mixed, client_email?: mixed, private_key?: mixed}
     */
    private function getCredentials(): array
    {
        $path = config('services.firebase.credentials');

        if (! is_string($path) || ! is_file($path) || ! is_readable($path)) {
            throw new RuntimeException('Firebase service-account credentials are not configured on the server.');
        }

        $credentials = json_decode(file_get_contents($path), true);

        if (! is_array($credentials) || ! isset($credentials['client_email'], $credentials['private_key'])) {
            throw new RuntimeException('Firebase service-account credentials are invalid.');
        }

        return $credentials;
    }

    /**
     * @param  array{project_id?: mixed, client_email?: mixed, private_key?: mixed}  $credentials
     */
    private function getAccessToken(array $credentials): string
    {
        $cacheKey = 'firebase_fcm_access_token_'.sha1((string) $credentials['client_email']);

        if (($cachedToken = Cache::get($cacheKey)) && is_string($cachedToken)) {
            return $cachedToken;
        }

        $issuedAt = time();
        $claims = [
            'iss' => $credentials['client_email'],
            'scope' => self::FCM_SCOPE,
            'aud' => self::OAUTH_TOKEN_URL,
            'iat' => $issuedAt,
            'exp' => $issuedAt + 3600,
        ];

        $unsignedJwt = $this->base64UrlEncode(json_encode(['alg' => 'RS256', 'typ' => 'JWT'], JSON_THROW_ON_ERROR))
            .'.'.$this->base64UrlEncode(json_encode($claims, JSON_THROW_ON_ERROR));
        $privateKey = openssl_pkey_get_private($credentials['private_key']);

        if ($privateKey === false || ! openssl_sign($unsignedJwt, $signature, $privateKey, OPENSSL_ALGO_SHA256)) {
            throw new RuntimeException('Firebase service-account private key could not sign an access token.');
        }

        $response = Http::asForm()
            ->acceptJson()
            ->timeout(15)
            ->post(self::OAUTH_TOKEN_URL, [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $unsignedJwt.'.'.$this->base64UrlEncode($signature),
            ]);

        if ($response->failed()) {
            throw new RuntimeException('Google OAuth rejected the Firebase service account.');
        }

        $accessToken = $response->json('access_token');

        if (! is_string($accessToken) || $accessToken === '') {
            throw new RuntimeException('Google OAuth returned no Firebase access token.');
        }

        Cache::put($cacheKey, $accessToken, now()->addSeconds(max(60, ((int) $response->json('expires_in', 3600)) - 60)));

        return $accessToken;
    }

    private function base64UrlEncode(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }
}
