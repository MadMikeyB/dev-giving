<?php

namespace Sprocketbox\DevGiving\Entities\Users;

use Illuminate\Contracts\Auth\Authenticatable;
use Sprocketbox\Articulate\Contracts\AuthRepository;
use Sprocketbox\Articulate\Contracts\Criteria;
use Sprocketbox\Articulate\Sources\Illuminate\Criteria\ByKey;
use Sprocketbox\Articulate\Sources\Illuminate\IlluminateRepository;

/**
 * User Repository
 *
 * @method \Sprocketbox\DevGiving\Entities\Users\User|null getOneByCriteria(Criteria ...$criteria)
 * @method \Sprocketbox\DevGiving\Entities\Users\User persist(User $user)
 *
 * @package Sprocketbox\DevGiving\Entities\Users
 */
class UserRepository extends IlluminateRepository implements AuthRepository
{

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed $identifier
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier): ?Authenticatable
    {
        return $this->getOneByCriteria(new ByKey($identifier));
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param  mixed  $identifier
     * @param  string $token
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token): ?Authenticatable
    {
        return $this->pushCriteria(new ByKey($identifier))
                    ->applyCriteria($this->query())
                    ->where('remember_token', '=', $token)
                    ->first();
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|\Sprocketbox\DevGiving\Entities\Users\User $user
     * @param  string                                                                                $token
     *
     * @return void
     */
    public function updateRememberToken(Authenticatable $user, $token): void
    {
        $user->rememberToken = $token;
        $this->persist($user);
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array $credentials
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials): ?Authenticatable
    {
        $credentials = array_except($credentials, ['password']);

        $query = $this->query();

        foreach ($credentials as $column => $value) {
            $query->where($column, '=', $value);
        }

        return $query->first();
    }
}