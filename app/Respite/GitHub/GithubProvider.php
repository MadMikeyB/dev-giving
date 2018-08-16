<?php

namespace Sprocketbox\DevGiving\Respite\GitHub;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Sprocketbox\Respite\Providers\OAuth2Provider;

class GithubProvider extends OAuth2Provider
{

    /**
     * Return a fresh HTTP client.
     *
     * @return \GuzzleHttp\ClientInterface
     */
    public function getHttpClient(): ClientInterface
    {
        return new Client(['base_uri' => $this->config['base_url'] ?? '']);
    }

    /**
     * Return an array of headers for the HTTP requests.
     *
     * @return array
     */
    public function getHeaders(): array
    {
        $headers = [];

        if ($this->accessToken) {
            $headers['Authorization'] = 'Bearer ' . $this->accessToken;
        }

        return $headers;
    }
}