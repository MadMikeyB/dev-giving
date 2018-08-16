<?php

namespace Sprocketbox\DevGiving\Respite\JustGiving\OAuth2\Provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Provider
 *
 * @package Ollieread\OAuth2\JustGiving
 */
class JustGiving extends AbstractProvider
{

    protected $sandbox = false;

    protected function getBaseUrl()
    {
        return $this->sandbox ? 'https://identity.sandbox.justgiving.com' : 'https://identity.justgiving.com';
    }

    public function getApiUrl()
    {
        return $this->sandbox ? 'https://api.sandbox.justgiving.com/v1' : 'https://api.justgiving.com/v1';
    }

    /**
     * Returns the base URL for authorizing a client.
     *
     * Eg. https://oauth.service.com/authorize
     *
     * @return string
     */
    public function getBaseAuthorizationUrl()
    {
        return $this->getBaseUrl() . '/connect/authorize';
    }

    /**
     * Returns the base URL for requesting an access token.
     *
     * Eg. https://oauth.service.com/token
     *
     * @param array $params
     *
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return $this->getBaseUrl() . '/connect/token';
    }

    /**
     * Returns the URL for requesting the resource owner's details.
     *
     * @param AccessToken $token
     *
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return $this->getApiUrl() . '/account';
    }

    /**
     * Returns the default scopes used by this provider.
     *
     * This should only be the scopes that are required to request the details
     * of the resource owner, rather than all the available scopes.
     *
     * @return array
     */
    protected function getDefaultScopes()
    {
        return ['openid', 'profile', 'email', 'account', 'offline_access', 'donations', 'fundraise'];
    }

    protected function getScopeSeparator()
    {
        return ' ';
    }

    protected function getAuthorizationParameters(array $options)
    {
        $params          = parent::getAuthorizationParameters($options);
        $params['nonce'] = uniqid('', true);

        return $params;
    }

    /**
     * Checks a provider response for errors.
     *
     * @throws IdentityProviderException
     *
     * @param  ResponseInterface $response
     * @param  array|string      $data Parsed response data
     *
     * @return void
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        if ($response->getStatusCode() !== 200) {
            $error = $data['error'] ?? $response->getStatusCode();
            throw new IdentityProviderException($response->getReasonPhrase(), $error, $data);
        }
    }

    /**
     * Generates a resource owner object from a successful resource owner
     * details request.
     *
     * @param  array       $response
     * @param  AccessToken $token
     *
     * @return ResourceOwnerInterface
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        $userDetails = array_intersect_key($response, array_flip([
            'accountId',
            'country',
            'firstName',
            'lastName',
            'town',
            'userId',
        ]));

        $userDetails['pageCount'] = $response['activePageCount'];
        $timestamp                = substr($response['joinDate'], 6, -7);
        $timezone                 = substr($response['joinDate'], -7, -2);
        $userDetails['joinDate']  = \DateTime::createFromFormat('UO', ($timestamp / 1000) . $timezone);

        foreach ($response['profileImageUrls'] as $image) {
            if ($image['Key'] === 'Size150x150Face') {
                $userDetails['profileImage'] = $image['Value'];
            }
        }

        return new JustGivingUser($userDetails);
    }

    protected function getAuthorizationHeaders($token = null)
    {
        return ['Authorization' => 'Bearer ' . $token];
    }

    protected function getDefaultHeaders()
    {
        return [
            'Accept'            => 'application/json',
            'x-api-key'         => $this->clientId,
            'x-application-key' => $this->clientSecret,
        ];
    }

    protected function getAccessTokenOptions(array $params)
    {
        $options                             = parent::getAccessTokenOptions($params);
        $options['headers']['Authorization'] = 'Basic ' . base64_encode($this->clientId . ':' . $this->clientSecret);

        return $options;
    }
}