<?php

use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Services\GS1DataMatrixTemplateService;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/history', [HistoryController::class, 'get']);

Route::post('/signup', [LoginController::class, 'signup']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/reset-password', [LoginController::class, 'resetPassword']);
Route::post('/update-password', [LoginController::class, 'updatePassword']);

Route::middleware('throttle:limit')->group(function () {
    Route::post('/get-svg', function (Request $request) {
        $codes = $request->input('codes');
        if($codes == null){
            return response()->json(['message' => 'Error', 'code' => '202']);
        }
        $dataGs1 = array();
        foreach ($codes as $code){
            $dataGs1[] =  GS1DataMatrixTemplateService::template1(base64_decode($code));
        }
        return response()->json(['data' => $dataGs1]);
    });
});
