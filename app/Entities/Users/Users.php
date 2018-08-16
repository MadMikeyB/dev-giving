<?php

namespace Sprocketbox\DevGiving\Entities\Users;

use Illuminate\Contracts\Auth\Guard;
use Laravel\Socialite\Contracts\User as GithubUser;
use Sprocketbox\DevGiving\Entities\Users\Criteria\ByGithubUser;
use Sprocketbox\Respite\Respite;

class Users
{
    /**
     * @var \Sprocketbox\DevGiving\Entities\Users\UserRepository
     */
    private $userRepository;
    /**
     * @var \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    private $guard;

    /**
     * @var \Sprocketbox\Respite\Respite
     */
    private $respite;

    public function __construct(Guard $guard, UserRepository $userRepository, Respite $respite)
    {
        $this->guard          = $guard;
        $this->userRepository = $userRepository;
        $this->respite        = $respite;
    }

    public function authFromGithub(GithubUser $githubUser): ?User
    {
        $user = $this->userRepository->getOneByCriteria(new ByGithubUser($githubUser));

        if (! $user) {
            $user = (new User)->createFromGithub($githubUser);
        } else {
            $user->updateFromGithub($githubUser);
        }

        if ($user->isDirty()) {
            $this->userRepository->persist($user);
        }

        if ($user->isPersisted()) {
            $this->guard->login($user);
            return $user;
        }

        return null;
    }

    private function github()
    {
        if ($this->guard->check()) {
            $user = $this->guard->user();
            $this->respite->getProvider('github')->setAccessToken($user->token);
        }

        return $this->respite->for('github');
    }

    public function getRepositories()
    {
        $user = $this->guard->user();

        if ($user) {
            $builder = $this->github();
            return $builder->get('/user/repos?visibility=public&sort=pushed')->header('Accept', 'application/vnd.github.mercy-preview+json')->contents();
        }

        return [];
    }
}