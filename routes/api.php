<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CheckoutController;
use App\Http\Controllers\API\GambarController;
use App\Http\Controllers\API\ProdukController;
use App\Http\Controllers\API\SliderController;
use App\Http\Controllers\CicilanController;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/insertproduct', [ProdukController::class, 'insertproduct']);
    Route::post('/updateproduct', [ProdukController::class, 'updateproduct']);
    Route::post('/deleteproduct', [ProdukController::class, 'deleteproduct']);

    //Transaksi
    Route::get('/gettransaksiadmin', [CheckoutController::class, 'gettransaksiadmin']);
    Route::get('/totalpenghasilan', [CheckoutController::class, 'totalpenghasilan']);
    Route::get('/gettransaksibystatusadmin/{status?}', [CheckoutController::class, 'gettransaksibystatusadmin']);
    Route::get('/totalpenghasilantahunini/{tahun?}', [CheckoutController::class, 'totalpenghasilantahunini']);
    Route::get('/totalpenghasilanbulanini/{tahun?&bulan?}', [CheckoutController::class, 'totalpenghasilanbulanini']);
    Route::get('/totalpenghasilanhariini/{tahun?&bulan?&hari?}', [CheckoutController::class, 'totalpenghasilanhariini']);
    Route::post('/updatestatuscheckout', [CheckoutController::class, 'updatestatuscheckout']);
    

    //Gambar
    Route::post('/insertgambar', [GambarController::class, 'insertgambar']);
    Route::get('/getgambar', [GambarController::class, 'getgambar']);
    Route::post('/deletegambar', [GambarController::class, 'deletegambar']);

});

    //Gambar
    Route::get('/getgambarcustomer', [GambarController::class, 'getgambarcustomer']);

    Route::get('/getproduct', [ProdukController::class, 'getproduct']);
    Route::get('/getprodukoption/{kategori?}', [ProdukController::class, 'getprodukoption']);
    //checkout
    Route::post('/checkout', [CheckoutController::class, 'checkout']);
    Route::get('/getdetailtransaksi/{idusers?&nomorpesanan?}', [CheckoutController::class, 'getdetailtransaksi']);
    Route::get('/getprodukcheckout/{idusers?&nomorpesanan?}', [CheckoutController::class, 'getprodukcheckout']);
    Route::get('/gettransaksibyidusers/{idusers?}', [CheckoutController::class, 'gettransaksibyidusers']);

    //Cicilan
    Route::post('/cicilan', [CicilanController::class, 'cicilan']);
    Route::post('/updatestatuscicilan', [CicilanController::class, 'updatestatuscicilan']);
    Route::post('/updatejatuhtempo', [CicilanController::class, 'updatejatuhtempo']);
    Route::post('/updatesudahbayar', [CicilanController::class, 'updatesudahbayar']);
    Route::post('/finishcicilan', [CicilanController::class, 'finishcicilan']);
    Route::get('/getcicilan', [CicilanController::class, 'getcicilan']);
    Route::get('/getcicilanakun/{idusers?}', [CicilanController::class, 'getcicilanakun']);
    Route::get('/readbayarcicilan/{nomorpesanan?}', [CicilanController::class, 'readbayarcicilan']);
    Route::get('/getsumcicilanakun/{nomorpesanan?}', [CicilanController::class, 'getsumcicilanakun']);

    //Cat
    Route::post('/addcart', [CartController::class, 'addcart']);
    Route::post('/updatejumlah', [CartController::class, 'updatejumlah']);
    Route::post('/deletecart', [CartController::class, 'deletecart']);
    Route::post('/pickcart', [CartController::class, 'pickcart']);
    Route::post('/sumcart', [CartController::class, 'sumcart']);
    Route::get('/getcart/{idusers?}', [CartController::class, 'getcart']);

    //Slider
    Route::post('/insertslider', [SliderController::class, 'insertslider']);
    Route::get('/getslider', [SliderController::class, 'getslider']);
    Route::post('/deleteslider', [SliderController::class, 'deleteslider']);

    
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
