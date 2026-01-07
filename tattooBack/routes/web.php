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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

//auth
$router->group(['prefix' => 'auth'], function() use ($router){
    $router->post ('/register','AuthController@register'); //goods
    $router->post ('/login','AuthController@login'); //goods
    $router->get ('/{id}','AuthController@show'); //goods
    $router->put ('/{id}','AuthController@update'); //not working yet 
    $router->delete ('/{id}','AuthController@destroy');
    $router->post ('/logout','AuthController@logout');//goods
});

//servicess
$router->group(['prefix' => 'service'], function() use ($router){
    $router->post ('/create','ServicesController@store'); //goods
    $router->get ('/allServices','ServicesController@index');//goods
    $router->get ('/allServices/{id}','ServicesController@show');//goods
    $router->delete ('/allServices/{id}','ServicesController@destroy');//goods
    //$router-> ('',''); EDIT TO BE FOLLEWED
});

//appointments
$router->group(['prefix' => 'appointment'], function() use ($router){
    $router->post ('/','AppointmentsController@store'); //tested - good
    $router->get ('/','AppointmentsController@index'); //tested - good
    $router->delete ('/{id}', 'AppointmentsController@destroy'); //tested - good

});
