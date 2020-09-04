<?php

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

//institutions
Route::get('institutions', 'InstitutionsController@index');
Route::post('institutions/simulate', 'InstitutionsController@simulate');

//covenants
Route::get('covenants', 'CovenantsController@index');
