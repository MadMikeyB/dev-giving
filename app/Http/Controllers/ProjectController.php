<?php

namespace Sprocketbox\DevGiving\Http\Controllers;

use Sprocketbox\DevGiving\Entities\Users\Users;

class ProjectController extends Controller
{
    /**
     * @var \Sprocketbox\DevGiving\Entities\Users\Users
     */
    private $users;

    public function __construct(Users $users)
    {
        $this->users = $users;
    }

    public function create()
    {
        $repos = $this->users->getRepositories();
        return view('project.create', compact('repos'));
    }
}