<?php

use App\Events\DeleteMessageEvent;
use App\Events\SendMessageEvent;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/getuser/{id}', function(Request $request){
        $user = User::find($request->id);
        return $user? $user:abort(404);
    });
    Route::patch('/updateprofile', function(Request $request){
        $request->validate([
            'name' => ['required']
        ]);
        return $request->user()->update(['name' => $request->name]);
    });
    Route::get('/authenticated', function(Request $request){
        return true;
    });
    Route::get('/conversations', function(Request $request){
        return $request->user()->conversations();
    });
    Route::get('/messages/{id}', function(Request $request){
        return $request->user()->messagedWith($request->id);
    });
    Route::get('/messages/{id}/{limit}', function(Request $request){
        return $request->user()->messagedWith($request->id, $request->limit);
    });
    Route::post('/send', function(Request $request){
        $request->validate(['content' => ['required']]);
        $message = $request->user()->send($request->receiver_id,$request->content);
        broadcast(new SendMessageEvent($message));
        return $message;
    });
    Route::post('/delete', function(Request $request){
        $message = $request->user()->sent->find($request->id);
        if($message) broadcast(new DeleteMessageEvent($message));
        $message->delete();
        return $message;
    });
    Route::get('/search/{name}', function(Request $request){
        return User::where('name', 'like', "$request->name%")->get();
    });
});

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout']);
