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
$app->get('/', function(){
	return 'success';
});

//Default route to be called
$app->get('/prezis/', 'MainController@prezis');

//This route will be used for pagination
$app->get('/prezis/{skip}', 'MainController@prezis');

//Ordered by date
$app->get('/ordered/prezis', 'MainController@prezisOrdered');

//Ordered by date and pagination
$app->get('ordered/prezis/{skip}', 'MainController@prezisOrdered');

//This route will search by title
$app->get('/search/{string}', 'MainController@search');
