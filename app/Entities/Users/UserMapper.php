<?php

namespace Sprocketbox\DevGiving\Entities\Users;

use Sprocketbox\Articulate\Contracts\EntityMapping;
use Sprocketbox\Articulate\Entities\EntityMapper;

class UserMapper extends EntityMapper
{

    public function entity(): string
    {
        return User::class;
    }

    public function source(): string
    {
        return 'illuminate';
    }

    /**
     * @param \Sprocketbox\Articulate\Contracts\EntityMapping|\Sprocketbox\Articulate\Sources\Illuminate\IlluminateEntityMapping $mapping
     */
    public function map(EntityMapping $mapping)
    {
        $mapping->setKey('id');
        $mapping->setTable('users');
        $mapping->setRepository(UserRepository::class);

        $mapping->int('id')->isImmutable();
        $mapping->int('github_id');
        $mapping->string('username');
        $mapping->string('email');
        $mapping->string('name');
        $mapping->string('avatar');
        $mapping->string('token');
        $mapping->string('token_refresh');
        $mapping->int('token_expires')->setDefault(0);
        $mapping->timestamps();
    }
}