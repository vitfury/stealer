<?php

use App\Models\Stats;
use Illuminate\Support\Facades\Route;

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
    (new Stats)->fill(['event_code' => Stats::STATS_CODES['home_page_visit']])->save();
    return view('main');
});

$router->get('/en/login/signin', function () use ($router) {
    (new Stats)->fill(['event_code' => Stats::STATS_CODES['fake_login_page_visit']])->save();
    return view('login');
});

$router->post('/en/login', ['uses' => 'LoginController@post']);
$router->get('/en/login', ['uses' => 'LoginController@get']);
$router->get('/en/login/redirect', ['uses' => 'LoginController@redirect']);
$router->get('/en/login/socials', ['uses' => 'LoginController@socials']);

