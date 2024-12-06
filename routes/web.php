<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\ShortenerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
    Controller/API
*/
Route::post('/api/v1/register', [ShortenerController::class, 'register']);
Route::post('/api/v1/Auth', [ShortenerController::class, 'Auth']);
Route::post('/api/v1/short-urls', [ShortenerController::class, 'index']);



 