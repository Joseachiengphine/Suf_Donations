<?php

use App\Http\Controllers\EncryptionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PaymentWebHookController;

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

//Route::get('/', function () {return view('welcome');});
Route::get('/login', [IndexController::class, 'loginView'])->name('login');
Route::post('/login_user', [IndexController::class, 'login_user'])->name('loginUser');

Route::match(['post','get'],'/vcrun', [IndexController::class, 'vcRunView'])->name('vcRunView');

Route::get('/autocomplete', [IndexController::class, 'autoComplete'])->name('autocomplete');

Route::get('/signup', [IndexController::class, 'signupView'])->name('signupView');
Route::post('/create_user', [IndexController::class, 'create_user'])->name('createUser');

Route::get('/report', [IndexController::class, 'reportView'])->name('report');
Route::any('/generateReport', [IndexController::class, 'generateReport']);
Route::get('/downloadReport/{fromDate}/{toDate}', [IndexController::class, 'export'])->name('downloadReport');


Route::get('/logout', [IndexController::class, 'logout'])->name('logout');

Route::post('/api/encrypt/{donationCode}', [EncryptionController::class, 'encrypt']);

Route::post('/api/saveCampaignOption', [\App\Http\Controllers\IndexController::class, 'saveCampaignOption']);

Route::post('/api/encrypt/{donationCode}', \App\Http\Controllers\EncryptionController::class);
Route::post('/api/saveDonationRequest', [\App\Http\Controllers\IndexController::class, 'saveDonationRequest']);
Route::post('/api/saveVcRunDonationRequest', [\App\Http\Controllers\IndexController::class, 'saveVcRunDonationRequest']);
Route::post('/api/paymentWebHookResponse', \App\Http\Controllers\PaymentWebHookController::class);
Route::post('/api/vcrun-webhook-response', [\App\Http\Controllers\PaymentWebHookController::class, 'vcrunResponse']);
Route::get('/', 'App\Http\Controllers\IndexController');
Route::get('/{donationCode}', [\App\Http\Controllers\IndexController::class, 'paramPage']);
