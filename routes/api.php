<?php

use App\Http\Controllers\ContactsController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;



Route::post('auth', [Controller::class, 'auth']);

// contacts
Route::middleware('auth:sanctum')->prefix('contacts')->group(function () {

    Route::get('', [ContactsController::class, 'index']);
    Route::post('', [ContactsController::class, 'create']);
    Route::post('{id}', [ContactsController::class, 'update']);
    Route::delete('{id}', [ContactsController::class, 'delete']);
    Route::get('search/{keyword}', [ContactsController::class, 'search']);

});




