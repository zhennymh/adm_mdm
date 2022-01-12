<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth_Controller;
use App\Http\Controllers\Dashboard_Controller;
use App\Http\Controllers\IdGenerator_Controller;
use App\Http\Controllers\Pelayanan_Controller;

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
//     echo "<a href='/logout'>Logout</a>";
// })->middleware('auth');

//route untuk controller auth -> login, logout
Route::get('/login', [Auth_Controller::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [Auth_Controller::class, 'authenticate']);
Route::post('/logout', [Auth_Controller::class, 'logout'])->middleware('auth');

//route untuk controller dashboard -> superadmin only
Route::get('/', [Dashboard_Controller::class, 'index'])->middleware(['auth', 'isSuperAdmin']);
Route::get('/users', [Dashboard_Controller::class, 'users'])->middleware(['auth', 'isSuperAdmin']);
Route::post('/getUsers', [Dashboard_Controller::class, 'getUsers'])->middleware(['auth', 'isSuperAdmin']);
Route::post('/getUserDetail', [Dashboard_Controller::class, 'getUserDetail'])->middleware(['auth', 'isSuperAdmin']);
Route::post('/updateUser', [Dashboard_Controller::class, 'updateUser'])->middleware(['auth', 'isSuperAdmin']);
Route::post('/deleteUser', [Dashboard_Controller::class, 'deleteUser'])->middleware(['auth', 'isSuperAdmin']);
Route::post('/addUser', [Dashboard_Controller::class, 'addUser'])->middleware(['auth', 'isSuperAdmin']);

Route::post('/getRoles', [Dashboard_Controller::class, 'getRoles'])->middleware(['auth', 'isSuperAdmin']);
Route::post('/getAllMenu', [Dashboard_Controller::class, 'getAllMenu'])->middleware(['auth', 'isSuperAdmin']);


Route::get('/idgenerator', [IdGenerator_Controller::class, 'index'])->middleware(['auth', 'isHaveAccess']);
Route::get('/idgen_getAlat', [IdGenerator_Controller::class, 'idgen_getAlat'])->middleware(['auth']);
Route::get('/idgen_getProvinsi', [IdGenerator_Controller::class, 'idgen_getProvinsi'])->middleware(['auth']);
Route::post('/idgen_getKabupaten', [IdGenerator_Controller::class, 'idgen_getKabupaten'])->middleware(['auth']);
Route::post('/idgen_getKecamatan', [IdGenerator_Controller::class, 'idgen_getKecamatan'])->middleware(['auth']);
Route::post('/idgen_getSite', [IdGenerator_Controller::class, 'idgen_getSite'])->middleware(['auth']);
Route::post('/idgen_getRadius', [IdGenerator_Controller::class, 'idgen_getRadius'])->middleware(['auth']);
Route::post('/idgen_getLatestId', [IdGenerator_Controller::class, 'idgen_getLatestId'])->middleware(['auth']);
Route::post('/idgen_saveSite', [IdGenerator_Controller::class, 'idgen_saveSite'])->middleware(['auth']);

Route::get('/pelayanandata', [Pelayanan_Controller::class, 'index'])->middleware(['auth', 'isHaveAccess']);
