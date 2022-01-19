<?php

use App\Exports\TestExcelExport;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

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

Route::get('/', function () {
    return Excel::download(new TestExcelExport(), 'test.xlsx');
});
Route::get('user', [UserController::class,'index']);
Route::get('download',  [UserController::class,'download'])->name('user.download');
