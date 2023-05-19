<?php
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\reqController;
use App\Http\Middleware\AdminMiddleware;
use App\Models\Collection;


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
    return view('welcome');
});

Route::prefix('admin')->middleware('auth', 'isAdmin')->group(function() {
    // admin only entry
    Route::get('/collections/create', [CollectionController::class, 'create'])->name('collections.create');
    Route::get('/collections/{collection}/edit', [CollectionController::class, 'edit'])->name('collections.edit');
    
});


Route::middleware(['auth', 'role.check'])->group(function () {
    Route::get('/book_create', function () {
        return view('BookCafe_Sys.book_create');
    });
    Route::get('/book_edit', function () {
        return view('BookCafe_Sys.book_edit');
    });
});



Route::get('/home', function () {
    return view('layouts.app');
});
Route::get('/landing', function () {
    return view('BookCafe.book_cafe');
});

Route::group(['middleware' => ['role.check']], function () {
    Route::resource('collections', CollectionController::class)->except(['create', 'edit']);
    Route::resource('authors', AuthorController::class);
});

Route::resource('genres', GenreController::class);//added
Route::resource('publishers', PublisherController::class);//added
Auth::routes();
Auth::routes(['logout' => true]);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/bookpdf', function () {
    $collections =Collection::all();
    return view('book-pdf')->with('collections', $collections);
});

Route::get('/chart-pdf', function () {
    $collections =Collection::all();
    return view('chart-pdf')->with('collections', $collections);
});

Route::get('/transaction1', function () {
    $collections =Collection::all();
    return view('transaction1')->with('collections', $collections);
});

Route::get('/collection/pdf', [CollectionController::class, 'generatePDF'])->name('collection.generatePDF');
Route::put('/collections/{collection}', [CollectionController::class, 'updateStatus'])->name('collection.updateStatus');
Route::resource('reqs', ReqController::class);//added
Route::put('/reqs/{req}', [ReqController::class, 'updateStatus'])->name('req.updateStatus');







