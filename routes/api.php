<?php
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController;

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

// Route::get('topic',function(){
//     return Post::all();
// });
/**
 * @OA\Get(
 *     path="/",
 *     description="Home page",
 *     @OA\Response(response="default", description="Welcome page")
 * )
 */
Route::get('posts','App\Http\Controllers\PostController@index');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/tokens/create', function (Request $request) {
    // $token = User::find(1)->createToken('tokenName');
    $user = User::find(1);

    // return ['token' => $token->plainTextToken];
    return $user->createToken('token-name', ['server:update'])->plainTextToken;
});

Route::group([
    // 'prefix' => 'v1', 
    // 'path' =>'/questions',
    // 'as' => 'api.', 
    // 'namespace' => 'Api\V1\Admin', 
    'middleware' => ['api']
    ], 
    function () {
    Auth::routes();
    Route::resource('/questions','App\Http\Controllers\QuestionController');
});

