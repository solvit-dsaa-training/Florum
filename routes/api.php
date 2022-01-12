<?php
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
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

Route::get('posts','App\Http\Controllers\PostController@index');
Route::Post('/login',[AuthController::class,'login']);
Route::Post('/register',[AuthController::class,'register']);
Route::get('/index',[UserController::class,'index']);
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::Post('/logout',[AuthController::class,'logout']);
});
 
