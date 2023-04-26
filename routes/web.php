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

$router->post('/auth', ['uses'=>'AuthenticationController@authenticate']);

$router->group(['middleware' => 'jwt.auth'], function () use ($router) {
$router->post('/creacliente', 'ClientesController@crearCliente');
$router->get('/listclientes', 'ClientesController@listarClientes');
$router->get('/kpideclientes','ClientesController@kpiClientes');
});
