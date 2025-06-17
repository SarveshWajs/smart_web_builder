<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GeneratorController;
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
Route::get('/components', [GeneratorController::class, 'components']);
Route::get('/themes', [GeneratorController::class, 'themes']);
Route::post('/generate', [GeneratorController::class, 'generate']);
Route::get('/project/{id}', [GeneratorController::class, 'project']);
Route::get('/project/{id}/html', [GeneratorController::class, 'html']);
