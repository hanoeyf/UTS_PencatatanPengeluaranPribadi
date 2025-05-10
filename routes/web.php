<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\AuthController;

Route::pattern('id', '[0-9]+'); // artinya ketika ada parameter {id}, maka harus berupa angka

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');


Route::middleware(['auth'])->group(function () {
    Route::get('/', [PemasukanController::class, 'index']);

    Route::group(['prefix' => 'pengeluaran'], function () {
        Route::get('/', [PengeluaranController::class, 'index']);
        Route::post('/list', [PengeluaranController::class, 'list']); // Hapus /user/ yang berlebihan
        Route::get('/create', [PengeluaranController::class, 'create']);
        Route::post('/', [PengeluaranController::class, 'store']); 
        Route::get('/create_ajax', [PengeluaranController::class, 'create_ajax']);
        Route::post('/ajax', [PengeluaranController::class, 'store_ajax']);
        Route::get('/{id}', [PengeluaranController::class, 'show']);  // Hapus /user/ yang berlebihan
        Route::get('/{id}/edit', [PengeluaranController::class, 'edit']);
        Route::put('/{id}', [PengeluaranController::class, 'update']);
        Route::get('/{id}/edit_ajax', [PengeluaranController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [PengeluaranController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [PengeluaranController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [PengeluaranController::class, 'delete_ajax']);
        Route::delete('/{id}', [PengeluaranController::class, 'destroy']);
        
    });
    Route::group(['prefix' => 'pemasukan'], function () {
        Route::middleware('authorize:ADM')->group(function () {
        Route::get('/', [PemasukanController::class, 'index']);
        Route::post('/list', [PemasukanController::class, 'list']); // Hapus /user/ yang berlebihan
        Route::get('/create', [PemasukanController::class, 'create']);
        Route::post('/', [PemasukanController::class, 'store']);
        Route::get('/create_ajax', [PemasukanController::class, 'create_ajax']);
        Route::post('/ajax', [PemasukanController::class, 'store_ajax']);
        Route::get('/{id}', [PemasukanController::class, 'show']);  // Hapus /user/ yang berlebihan
        Route::get('/{id}/edit', [PemasukanController::class, 'edit']);
        Route::put('/{id}', [PemasukanController::class, 'update']);
        Route::get('/{id}/edit_ajax', [PemasukanController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [PemasukanController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [PemasukanController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [PemasukanController::class, 'delete_ajax']);
        Route::delete('/{id}', [PemasukanController::class, 'destroy']);
        });
    });
});


