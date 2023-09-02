<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AgenciesController;
use App\Http\Controllers\VehiculesController;
use App\Http\Controllers\OffersController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\ClientsController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ( $router) {
    $router->post('/login', [AuthController::class, 'login']);
    $router->post('/register', [AuthController::class, 'register']);
    $router->post('/logout', [AuthController::class, 'logout']);
    $router->post('/refresh', [AuthController::class, 'refresh']);
    $router->get('/user-profile', [AuthController::class, 'userProfile']);    
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'agencies'
], function ( $router) {
    $router->get('/',[AgenciesController::class,'index']);
    $router->post('/store',[AgenciesController::class,'store']);
    $router->get('/show/{id}',[AgenciesController::class,'show']);
    $router->put('/update/{id}',[AgenciesController::class,'update']);
    $router->delete('/delete/{id}',[AgenciesController::class,'delete']);
    $router->get('/Search/{name}',[AgenciesController::class,'Search']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'vehicules'
], function ($router) {
    $router->get('/',[VehiculesController::class,'index']);
    $router->post('/store',[VehiculesController::class,'store']);
    $router->get('/show/{id}',[VehiculesController::class,'show']);
    $router->post('/update/{id}',[VehiculesController::class,'update']);
    $router->delete('/delete/{id}',[VehiculesController::class,'delete']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'offers'
], function ($router) {
    $router->get('/',[OffersController::class,'index']);
    $router->post('/store',[OffersController::class,'store']);
    $router->get('/show/{id}',[OffersController::class,'show']);
    $router->put('/update/{id}',[OffersController::class,'update']);
    $router->delete('/delete/{id}',[OffersController::class,'delete']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'bookings'
], function ($router) {
    $router->get('/',[BookingsController::class,'index']);
    $router->post('/store',[BookingsController::class,'store']);
    $router->get('/show/{id}',[BookingsController::class,'show']);
    $router->put('/update/{id}',[BookingsController::class,'update']);
    $router->delete('/delete/{id}',[BookingsController::class,'destroy']);
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'clients'
], function ($router) {
    $router->get('/',[ClientsController::class,'index']);
    $router->post('/store',[ClientsController::class,'store']);
    $router->get('/show/{id}',[ClientsController::class,'show']);
    $router->get('/detail/{id}',[ClientsController::class,'detail']);
    $router->put('/update/{id}',[ClientsController::class,'update']);
    $router->delete('/delete/{id}',[ClientsController::class,'destroy']);
});