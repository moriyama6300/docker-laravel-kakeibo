<?php declare(strict_types=1);

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('home');
// })->name('home');

Route::get('/', 'MainController@home')->name('home');
Route::post('/input', 'MainController@input')->name('input');
Route::post('/reference', 'MainController@reference')->name('reference');
Route::post('/addCategory', 'MainController@addCategory')->name('addCategory');
Route::post('/delCategory', 'MainController@delCategory')->name('delCategory');
