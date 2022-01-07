<?php

use App\Http\Controllers\ApiControllers\TaskCompletionController;
use App\Http\Controllers\ApiControllers\TaskController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('tasks')->group(function() {
    Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/{task_id}', [TaskController::class, 'show'])->name('tasks.show');
    Route::patch('/{task_id}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/{task_id}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    Route::post('/{task}/complete', [TaskCompletionController::class, 'markAsCompleted'])->name('tasks.completion.complete');
    Route::post('/{task}/incomplete', [TaskCompletionController::class, 'markAsIncompleted'])->name('tasks.completion.incomplete');
});
