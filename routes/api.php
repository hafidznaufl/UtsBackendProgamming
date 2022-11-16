<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::group([
    'middleware' => 'auth:sanctum'
], function () {
//Router method GET mengakses fungsi index
Route::get('/patients', [PatientsController::class, 'index']);
//Router method POST mengakses fungsi store
Route::post('/patients', [PatientsController::class, 'store']);
//Router method GET mengakses fungsi show
Route::get('/patients/{id}', [PatientsController::class, 'show']);
//Router method PUT mengakses fungsi update
Route::put('/patients/{id}', [PatientsController::class, 'update']);
//Router method DELETE mengakses fungsi destroy
Route::delete('patients/{id}', [PatientsController::class, 'destroy']);
//Router method GET mengakses fungsi search
Route::get('/patients/search/{name}', [PatientsController::class, 'search']);
//Router method GET mengakses fungsi positive
Route::get('/patients/status/positive', [PatientsController::class, 'positive']);
//Router method GET mengakses fungsi recovered
Route::get('/patients/status/recovered', [PatientsController::class, 'recovered']);
//Router method GET mengakses fungsi dead
Route::get('/patients/status/dead', [PatientsController::class, 'dead']);
});