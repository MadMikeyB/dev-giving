<?php

use Illuminate\Routing\Router;

/**
 * @var Router $router
 */

$router->get('/')->name('home')->uses('HomepageController@index');

$router->group(['prefix' => '/github'], function (Router $router) {
    $router->get('/')->name('github.create')->uses('GithubController@create');
    $router->get('/auth')->name('github.store')->uses('GithubController@store');
});

$router->group(['middleware' => 'auth:web'], function (Router $router) {
    $router->get('/add')->name('project.create')->uses('ProjectController@create');
});