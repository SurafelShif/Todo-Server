<?php

use App\Http\Controllers\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(TodoController::class)->prefix("todos")->group(function(){

});