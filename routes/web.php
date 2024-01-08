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

$router->post('/clock-in', 'AbsensiController@clockIn');

//Information akun
$router->get('/users',  'UserController@index');
$router->get('/users/{id}', 'UserController@show');
$router->post('/users', 'UserController@store');
$router->put('/users/{id}', 'UserController@update');
$router->delete('/users/{id}', 'UserController@destroy');

//FAQ
$router->get('/faq', 'FAQController@index');
$router->get('/faq/{id}', 'FAQController@show');
$router->post('/faq', 'FAQController@store');
$router->put('/faq/{id}', 'FAQController@update');
$router->delete('/faq/{id}', 'FAQController@destroy');

//ganti password

$router->put('/change-password', 'UserController@changePassword');