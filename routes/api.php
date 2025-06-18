<?php

use App\Http\Controllers\PhoneValidationController;
use Illuminate\Support\Facades\Route;

Route::get('/v1/validate-number', PhoneValidationController::class);
