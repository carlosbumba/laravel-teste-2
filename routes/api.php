<?php

use App\Http\Controllers\PhoneValidationController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:validate-number')->get('/v1/validate-number', PhoneValidationController::class)->name('api.validate-number');
