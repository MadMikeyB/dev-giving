<?php

namespace Sprocketbox\DevGiving\Http\Controllers;

use Laravel\Socialite\Two\GithubProvider;
use Sprocketbox\DevGiving\Entities\Users\Users;

class GithubController extends Controller
{
    /**
     * @var \Laravel\Socialite\Two\GithubProvider
     */
    private $github;
    /**
     * @var \Sprocketbox\DevGiving\Entities\Users\Users
     */
    private $users;

    public function __construct(GithubProvider $github, Users $users)
    {
        $this->github = $github;
        $this->users  = $users;
    }

    public function create()
    {
        return $this->github
            ->scopes([
                'read:user',
                'read:email',
                'public_repo',
            ])
            ->redirect();
    }

    public function store()
    {
        $user = $this->github->user();

        if ($this->users->authFromGithub($user)) {
            return redirect()->to('/');
        }

        echo 'uh oh';
    }
}