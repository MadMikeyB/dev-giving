<?php

namespace Sprocketbox\DevGiving\Respite\JustGiving\OAuth2\Grant;

use League\OAuth2\Client\Grant\AbstractGrant;

/**
 * Class Fundraise
 *
 * @package Ollieread\OAuth2\Client\Grant
 */
class Fundraise extends AbstractGrant
{

    /**
     * Returns the name of this grant, eg. 'grant_name', which is used as the
     * grant type when encoding URL query parameters.
     *
     * @return string
     */
    protected function getName()
    {
        return 'fundraise';
    }

    /**
     * Returns a list of all required request parameters.
     *
     * @return array
     */
    protected function getRequiredRequestParameters()
    {
        return [];
    }
}