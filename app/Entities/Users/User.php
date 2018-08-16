<?php

namespace Sprocketbox\DevGiving\Entities\Users;

use Illuminate\Contracts\Auth\Authenticatable;
use Laravel\Socialite\Contracts\User as GithubUser;
use Sprocketbox\Articulate\Entities\Entity;

/**
 * User
 *
 * @property-read int       $id
 * @property string         $username
 * @property string         $email
 * @property string         $avatar
 * @property string         $name
 * @property int            $githubId
 * @property string         $token
 * @property string         $tokenRefresh
 * @property int            $tokenExpires
 * @property string         $rememberToken
 * @property \Carbon\Carbon $createdAt
 * @property \Carbon\Carbon $updatedAt
 *
 * @package Sprocketbox\DevGiving\Entities\Users
 */
class User extends Entity implements Authenticatable
{
    /**
     * @param \Laravel\Socialite\Contracts\User|\Laravel\Socialite\Two\User $githubUser
     *
     * @return \Sprocketbox\DevGiving\Entities\Users\User
     */
    public function createFromGithub(GithubUser $githubUser): self
    {
        $this->username     = $githubUser->nickname;
        $this->email        = $githubUser->email;
        $this->avatar       = $githubUser->avatar;
        $this->name         = $githubUser->name;
        $this->githubId     = $githubUser->id;
        $this->token        = $githubUser->token;
        $this->tokenRefresh = $githubUser->refreshToken;
        $this->tokenExpires = $githubUser->expiresIn ?: null;

        return $this;
    }

    /**
     * @param \Laravel\Socialite\Contracts\User|\Laravel\Socialite\Two\User $githubUser
     *
     * @return \Sprocketbox\DevGiving\Entities\Users\User
     */
    public function updateFromGithub(GithubUser $githubUser): self
    {
        if ($this->username !== $githubUser->nickname) {
            $this->username = $githubUser->nickname;
        }

        if ($this->email !== $githubUser->email) {
            $this->email = $githubUser->email;
        }

        if ($this->avatar !== $githubUser->avatar) {
            $this->avatar = $githubUser->avatar;
        }

        if ($this->name !== $githubUser->name) {
            $this->name = $githubUser->name;
        }

        if ($this->token !== $githubUser->token) {
            $this->token = $githubUser->token;
        }

        if ($this->tokenRefresh !== $githubUser->refreshToken) {
            $this->tokenRefresh = $githubUser->refreshToken;
        }

        $expiresIn = $githubUser->expiresIn ?: null;

        if ($this->tokenExpires !== $expiresIn) {
            $this->tokenExpires = $expiresIn;
        }

        return $this;
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getAttribute('id');
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return '';
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        return $this->getAttribute($this->getRememberTokenName());
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string $value
     *
     * @return $this
     */
    public function setRememberToken($value)
    {
        $this->setAttribute($this->getRememberTokenName(), $value);
        return $this;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }
}