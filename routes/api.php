<?php

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\{
    PlanetController,
    PersonController,
    StarshipController
};

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
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::get('people/search', [PersonController::class, 'search'])
    ->name('people.search');
Route::apiResource('people', PersonController::class);

Route::get('planets/search', [PlanetController::class, 'search'])
    ->name('planets.search');
Route::apiResource('planets', PlanetController::class);

Route::get('starships/search', [PlanetController::class, 'search'])
    ->name('starships.search');
Route::apiResource('starships', StarshipController::class);