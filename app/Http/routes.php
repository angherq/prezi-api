<?php

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

//Default route to be called
$app->get('/prezis/', 'MainController@prezis');

//This route will be used for pagination
$app->get('/prezis/{skip}', 'MainController@prezis');

//This route will search by title
$app->get('/search/{string}', 'MainController@search');
