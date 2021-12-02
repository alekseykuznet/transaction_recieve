<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;

Route::prefix('task')->group(function () {

    Route::get('/recieve', [TaskController::class, 'recieve']);
});

