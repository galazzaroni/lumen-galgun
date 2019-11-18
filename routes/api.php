<?php
/** @var Router $router */

use Laravel\Lumen\Routing\Router;

/* Public Routes */
/*$router->get('/', function () {
    return response()->json(['message' => 'Welcome to Lumen API Starter']);
});*/
$router->get('/', function() {
    return view('/emails/welcome', ['name' => 'Gonzalo', 'token' => 'saraza']);
});

/* Auth Routes */
$router->group(['prefix' => 'auth', 'as' => 'auth'], function (Router $router) {

    /* Defaults */
    $router->post('/register', [
        'as' => 'register',
        'uses' => 'AuthController@register',
    ]);
    $router->post('/login', [
        'as' => 'login',
        'uses' => 'AuthController@login',
    ]);
    $router->get('/verify/{token}', [
        'as' => 'verify',
        'uses' => 'AuthController@verify'
    ]);

    /* Password Reset */
    $router->post('/password/forgot', [
        'as' => 'password.forgot',
        'uses' => 'AuthController@forgotPassword'
    ]);
    $router->post('/password/recover/{token}', [
        'as' => 'password.recover',
        'uses' => 'AuthController@recoverPassword'
    ]);

    /* Protected User Endpoint */
    $router->get('/user', [
        'uses' => 'AuthController@getUser',
        'as' => 'user',
        'middleware' => 'auth'
    ]);
});

$router->post('/s3/upload64', 'S3\S3Controller@store_64');
$router->post('/s3/upload', 'S3\S3Controller@store_file');
<<<<<<< HEAD
$router->post('/profile/profileByID', 'Profile\ProfileController@getProfile');
$router->post('/profile/addProfile', 'Profile\ProfileController@addProfile');
=======
$router->post('/profile/profileByID', 'Profile\ProfileController@profileByID');
>>>>>>> c7d0f07ff8e93399cf6bb142096f4e9e7bd92815

/* Protected Routes */
$router->group(['middleware' => 'auth'], function (Router $router) {

    $router->group(['middleware' => 'role:administrator'], function (Router $router) {

        $router->get('/admin', function () {
            return response()->json(['message' => 'You are authorized as an administrator.']);
        });

    });

});
