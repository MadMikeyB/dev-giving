<?php

namespace Sprocketbox\DevGiving\Entities\Users\Criteria;

use Laravel\Socialite\Contracts\User;
use Sprocketbox\Articulate\Criteria\BaseCriteria;

class ByGithubUser extends BaseCriteria
{
    /**
     * @var \Laravel\Socialite\Contracts\User
     */
    private $githubUser;

    public function __construct(User $githubUser)
    {
        $this->githubUser = $githubUser;
    }

    /**
     * @param \Sprocketbox\Articulate\Sources\Illuminate\IlluminateBuilder $query
     *
     * @return void
     */
    public function perform($query): void
    {
        $query->where('users.github_id', '=', $this->githubUser->getId());
    }
}