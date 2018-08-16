<?php

namespace Sprocketbox\DevGiving\Respite\JustGiving\OAuth2\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

/**
 * Class JustGivingUser
 *
 * @package Ollieread\OAuth2\Client\Provider
 */
class JustGivingUser implements ResourceOwnerInterface
{

    protected $accountId;

    protected $country;

    protected $firstName;

    protected $lastName;

    protected $town;

    protected $userId;

    protected $pageCount;

    protected $joinDate;

    protected $profileImage;

    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    /**
     * Returns the identifier of the authorized resource owner.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->accountId;
    }

    /**
     * Return all of the owner details available as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'accountId'    => $this->accountId,
            'country'      => $this->country,
            'firstName'    => $this->firstName,
            'lastName'     => $this->lastName,
            'town'         => $this->town,
            'userId'       => $this->userId,
            'pageCount'    => $this->pageCount,
            'joinDate'     => $this->joinDate,
            'profileImage' => $this->profileImage,
        ];
    }

    /**
     * @return mixed
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return mixed
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return mixed
     */
    public function getPageCount()
    {
        return $this->pageCount;
    }

    /**
     * @return mixed
     */
    public function getJoinDate()
    {
        return $this->joinDate;
    }

    /**
     * @return mixed
     */
    public function getProfileImage()
    {
        return $this->profileImage;
    }
}