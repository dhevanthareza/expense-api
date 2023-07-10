<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/


$router->group(['prefix' => 'user'], function () use ($router) {
    $router->post('register', 'UserController@register');
    $router->post('login', 'UserController@login');
});

$router->group(['middleware' => 'auth', 'prefix' => 'expense'], function () use ($router) {
    $router->get('/', 'ExpenseController@index');
    $router->get('/{expense_id}', 'ExpenseController@get');
    $router->post('/', 'ExpenseController@store');
    $router->put('/{expense_id}', 'ExpenseController@update');
    $router->patch('/{expense_id}', 'ExpenseController@update');
    $router->delete('/{expense_id}', 'ExpenseController@delete');
});