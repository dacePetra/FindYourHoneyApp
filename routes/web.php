<?php

use App\Http\Controllers\DislikeController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\MatchFindingController;
use App\Http\Controllers\PictureController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserInterestsController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;

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

Route::get('/', function () {return view('welcome');});

Route::get('/dashboard', function () {return redirect('find-your-honey');})->middleware(['auth'])->name('dashboard');

Route::get('/find-your-honey', [MatchFindingController::class, 'find'])->middleware(['auth'])->name('find-your-honey');

Route::get('/dislike/{id}', [DislikeController::class, 'dislike'])->middleware(['auth']);

Route::get('/like/{id}', [LikeController::class, 'like'])->middleware(['auth']);

Route::get('/cannot-find', function () {return view('cannot-find');})->middleware(['auth']);

Route::get('/my-honey-matches', [MatchController::class, 'index'])->middleware(['auth'])->name('matches');

Route::get('/revert-match/{id}', [MatchController::class, 'revertMatch'])->middleware(['auth']);

Route::get('/show/{id}', [UserController::class, 'show'])->middleware(['auth']);

Route::get('/my-likes', [LikeController::class, 'index'])->middleware(['auth'])->name('likes');

Route::get('/revert-like/{id}', [LikeController::class, 'revertLike'])->middleware(['auth']);

Route::get('/my-dislikes', [DislikeController::class, 'index'])->middleware(['auth'])->name('dislikes');

Route::get('/revert-dislike/{id}', [DislikeController::class, 'revertDislike'])->middleware(['auth']);

Route::get('/edit-profile', [UserProfileController::class, 'edit'])->middleware(['auth'])->name('edit');

Route::post('/edit-profile', [UserProfileController::class, 'update'])->middleware(['auth'])->name('update');

Route::get('/my-profile', [UserProfileController::class, 'myProfile'])->middleware(['auth'])->name('profile');

Route::get('/my-preferences', [UserInterestsController::class, 'preferences'])->middleware(['auth'])->name('preferences');

Route::post('/my-preferences', [UserInterestsController::class, 'store'])->middleware(['auth'])->name('updatePreferences');

Route::get('/gallery', [PictureController::class, 'index'])->middleware(['auth'])->name('gallery');

Route::post('/gallery', [PictureController::class, 'store'])->middleware(['auth']);

Route::get('/manage-gallery', [PictureController::class, 'manage'])->middleware(['auth'])->name('manageGallery');

Route::post('/manage-gallery', [PictureController::class, 'delete'])->middleware(['auth']);

Route::get('/manage-gallery-upload', [PictureController::class, 'upload'])->middleware(['auth']);

Route::get('/page-not-found', function () {return view('page-not-found');})->middleware(['auth'])->name('page-not-found');



require __DIR__.'/auth.php';
