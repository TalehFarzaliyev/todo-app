<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('', [\App\Http\Controllers\TodoController::class, 'index'])->middleware('xssProtection','todo');
Route::get('task/store', [\App\Http\Controllers\TodoController::class, 'store'])->middleware('xssProtection','todo');
Route::get('task/edit', [\App\Http\Controllers\TodoController::class, 'update'])->middleware('xssProtection','todo');
Route::get('task/delete', [\App\Http\Controllers\TodoController::class, 'delete'])->middleware('xssProtection','todo');
Route::get('task/mark', [\App\Http\Controllers\TodoController::class, 'complete'])->middleware('xssProtection','todo');
