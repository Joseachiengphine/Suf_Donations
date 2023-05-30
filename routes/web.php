<?php

use App\Http\Controllers\EncryptionController;
use App\Http\Controllers\PaymentWebHookController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;

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
//Route::get('login/login', [IndexController::class, 'loginView'])->name('login');
//Route::post('login/login_user', [IndexController::class, 'login_user'])->name('loginUser');

Route::match(['post','get'],'/vcrun', [IndexController::class, 'vcRunView'])->name('vcRunView');

//Route::get('/autocomplete', [IndexController::class, 'autoComplete'])->name('autocomplete');

//Route::get('/signup', [IndexController::class, 'signupView'])->name('signupView');
//Route::post('/create_user', [IndexController::class, 'create_user'])->name('createUser');


//Route::get('/logout', [IndexController::class, 'logout'])->name('logout');

Route::post('/api/encrypt/{donationCode}', [EncryptionController::class, 'encrypt']);

Route::post('/api/saveCampaignOption', [IndexController::class, 'saveCampaignOption']);

Route::post('/api/encrypt/{donationCode}', EncryptionController::class);
Route::post('/api/saveDonationRequest', [IndexController::class, 'saveDonationRequest']);
Route::post('/api/saveVcRunDonationRequest', [IndexController::class, 'saveVcRunDonationRequest']);
Route::post('/api/paymentWebHookResponse', [PaymentWebHookController::class]);
Route::post('/api/vcrun-webhook-response', [PaymentWebHookController::class, 'vcrunResponse']);
Route::get('/', 'App\Http\Controllers\IndexController');
Route::get('/{donationCode}', [IndexController::class, 'paramPage']);

//Route::any('{all}', function(){ return redirect('/'); })->where('all', '.*');
