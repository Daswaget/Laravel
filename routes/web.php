<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

//Route::get('user', [UserController::class, 'getData']);
//Route::get('user', function () {
//    return view('home');
//});

//Route::view('home', 'home')->middleware(middleware: 'auth');
//Route::view('userlist', 'userlist')->middleware(middleware: 'auth');
Route::view('home', 'home');
Route::view('userlist', 'userlist');

Route::view('user/{id}', 'user');
Route::view('user/{id}/library', 'library');
Route::view('user/{id}/library/write_book', 'writebook');
Route::view('user/{id}/library/write_book/ready', 'writebookready');
Route::view('user/{id}/library/{book}/edit_book', 'editbook');
Route::view('user/{id}/library/{book}/edit_book/ready', 'editbookready');
Route::view('user/{id}/library/{book}/book_link_access', 'booklinkaccess');
Route::view('user/{id}/library/{book}', 'book');
Route::view('user/{id}/library_access', 'libraryaccess');
Route::view('user/{id}/comment', 'comment');
Route::view('user/{id}/response', 'response');
Route::view('user/{id}/comment_remove/{comment}', 'commentremove');
Route::view('user/{id}/response_remove/{response}', 'responseremove');
