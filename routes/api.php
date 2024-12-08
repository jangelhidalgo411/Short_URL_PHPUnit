<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\ShortenerController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $r) {
    return "api working";
});

Route::get('/apitest', function () {
    return view('welcome');
});
Route::post('/v1/register', [ShortenerController::class, 'register']);
Route::post('/v1/Auth', [ShortenerController::class, 'Auth']);
Route::post('/v1/short-urls', [ShortenerController::class, 'Shortener'])->middleware('auth:sanctum');
