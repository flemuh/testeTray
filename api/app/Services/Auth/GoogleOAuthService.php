<?php

namespace App\Services\Auth;

use Google\Client as GoogleClient;
use Google\Service\Oauth2;

class GoogleOAuthService
{
    public function makeClient(): GoogleClient
    {
        $client = new GoogleClient();

        $client->setClientId((string) config('services.google.client_id'));
        $client->setClientSecret((string) config('services.google.client_secret'));
        $client->setRedirectUri((string) config('services.google.redirect_uri'));
        $client->setAccessType('offline');
        $client->setPrompt('consent');
        $client->setScopes([
            'openid',
            'email',
            'profile',
        ]);

        return $client;
    }

    public function getAuthUrl(): string
    {
        return $this->makeClient()->createAuthUrl();
    }

    public function fetchAccessToken(string $code): array
    {
        return $this->makeClient()->fetchAccessTokenWithAuthCode($code);
    }

    public function getGoogleUserDataByAccessToken(string $accessToken): array
    {
        $client = $this->makeClient();
        $client->setAccessToken($accessToken);

        $oauth2 = new Oauth2($client);
        $googleUser = $oauth2->userinfo->get();

        return [
            'google_id' => $googleUser->id,
            'email' => $googleUser->email,
            'name' => $googleUser->name,
            'verified_email' => $googleUser->verifiedEmail,
        ];
    }
}
