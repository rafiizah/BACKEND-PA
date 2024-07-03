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

use Laravel\Lumen\Http\Request;
use App\Http\Controllers\LumenAuthController;
use OpenApi\Annotations\Get;

$router->group(['prefix' => 'api', 'middleware' => 'cors',], function () use ($router) {

    //umkm
    $router->get('pemilik', 'pemilikController@index');
    $router->post('pemilik', 'pemilikController@store');
    $router->get('pemilik/{id}', 'pemilikController@show');
    $router->post('pemilik/{id}', 'pemilikController@update');
    $router->delete('pemilik/{id}', 'pemilikController@destroy');

    //chart umkm
    $router->get('chart-data', 'GetDataChart@getDataForChart');
    $router->get('chart-tahun', 'GetDataChart@getDataForTahunBerdiri');
    $router->get('chart-jenis', 'GetDataChart@getDataForJenis');

    //chart asosiasi
    $router->get('chart-dom-as', 'getDataChartAs@getDataChartAs');
    $router->get('chart-tahun-as', 'getDataChartAs@getDataForTahunAs');
    $router->get('chart-jumlah-as', 'getDataChartAs@getDataForJumlahAs');

    //asosiasi  
    $router->get('asosiasi', 'AsosiasiController@index');
    $router->post('asosiasi', 'AsosiasiController@store');
    $router->get('asosiasi/{id}', 'AsosiasiController@show');
    $router->post('asosiasi/{id}', 'AsosiasiController@update');
    $router->delete('asosiasi/{id}', 'AsosiasiController@destroy');

    //get count UMKM
    $router->get('/jumlah-umkm', 'pemilikController@hitungJumlahUMKM');
    $router->get('/jumlah-user', 'UserController@countUsers');
    $router->get('/jumlah-event', 'EventsController@hitungJumlahEvent');
    $router->get('/jumlah-asosiasi', 'AsosiasiController@hitungJumlahAsosiasi');

    //event
    $router->get('event', 'EventsController@index');
    $router->get('event/{id}', 'EventsController@show');
    $router->post('event', 'EventsController@store');
    $router->post('event/{id}', 'EventsController@update');
    $router->delete('event/{id}', 'EventsController@destroy');


    $router->post('login', 'LumenAuthController@login');
    $router->post('logout', 'LumenAuthController@logout');
    $router->post('refresh', 'LumenAuthController@refresh');
    $router->post('me', 'LumenAuthController@me');

    $router->get('/event-registrations', 'EventRegistrationController@index');
    $router->post('/event-registrations', 'EventRegistrationController@register');

    $router->post('/send-blast-email', 'EmailBlastingController@sendEmails');
    $router->post('/umkm/create', 'UMKMController@create');



    $router->group(['prefix' => 'umkmAsosiasi', 'name' => 'umkmAsosiasi'], function () use ($router) {
        $router->get('/', ['as' => 'index', 'uses' => 'UmkmAsosiasiController@index']);
        $router->get('/{id}', ['as' => 'read', 'uses' => 'UmkmAsosiasiController@read']);
        $router->post('/create', ['as' => 'create', 'uses' => 'UmkmAsosiasiController@create']);
        $router->post('/update/{id}', ['as' => 'update', 'uses' => 'UmkmAsosiasiController@update']);
        $router->delete('/delete/{id}', ['as' => 'delete', 'uses' => 'UmkmAsosiasiController@delete']);
    });
});

//verifikasi akun
$router->post('verifikasi', 'WebController@verifikasi_email');

//cru pemilik umkm