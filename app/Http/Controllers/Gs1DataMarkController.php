<?php

namespace App\Http\Controllers;


use App\Services\GS1DataMatrixTemplateService;
use Illuminate\Http\Request;

class Gs1DataMarkController extends Controller
{
    public function index(Request $request) {
        $codes = $request->input('codes');
        if (!$codes || !is_array($codes)) {
            return response()->json(['message' => 'Error', 'code' => '202']);
        }
        $dataGs1 = array_map(fn($code) => GS1DataMatrixTemplateService::template1($code), $codes);

        return response()->json(['data' => $dataGs1]);
    }
}
