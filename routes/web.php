<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PhotoController;

Route::get('/posts/{post}/comments/{comment}', function ($postId, $commentId) {
    return 'Pos ke-'.$postId." Komentar ke-: ".$commentId;
    });
    

    Route::get('/hello', function () { return 'Hello World';
    });
    

    Route::get('/world', function () { return 'World';
    });
    
    Route::get('/user/{name}', function ($name) { 
        return 'Nama saya '.$name;
    });

    Route::get('/posts/{post}/comments/{comment}', 
    function ($postId, $commentId) {
        return 'Pos ke-'.$postId." Komentar ke-: ".$commentId;
        });
        
    
    Route::resource('photos', PhotoController::class);

Route::get('/hello', [WelcomeController::class,'hello']);

Route::get('/', [PageController::class, 'index']);
Route::get('/about', [PageController::class, 'about']);
Route::get('/articles/{id}', [PageController::class, 'articles']);

Route::get('/', [HomeController::class, 'index']);
Route::get('/about', [AboutController::class, 'show']);
Route::get('/articles/{id}', [ArticleController::class, 'show']);

Route::get('/greeting', function () {
    return view('blog.hello', ['name' => 'Hanifah']);
    });

Route::get('/greeting', [WelcomeController::class, 'greeting']);
    


