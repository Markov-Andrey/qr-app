<?php

namespace App\Http\Controllers;


use App\Services\GS1DataMatrixTemplateService;
use Illuminate\Support\Facades\Request;

class Gs1DataMarkController extends Controller
{

    public function index(Request $request) {
        $codes  = [
            '0100194502876031213RhOJV25E&rmk91KZF092uLM7CO5MBKijWebalThibHT0C8o=uLM7CO5MBKijWebalThibHT0C8o=uLM7CO5MBKijWebalThibHT0C8o=uLM7',
            '0100194502876031213RhOJV25E&rmk91KZF092uLM7CO5MBKijWebalThibHT0C8o=uLM7CO5MBKijWebalThibHT0C8o=uLM7CO5MBKijWebalThibHT0C8o=uLM7',
            '0100194502876031213RhOJV25E&rmk91KZF092uLM7CO5MBKijWebalThibHT0C8o=uLM7CO5MBKijWebalThibHT0C8o=uLM7CO5MBKijWebalThibHT0C8o=uLM71',
            '0100194502876031213RhOJV25E&rmk91KZF092uLM7CO5MBKijWebalThibHT0C8o=uLM7CO5MBKijWebalThibHT0C8o=uLM7CO5MBKijWebalThibHT0C8o=uLM72',
            '0100194502876031213RhOJV25E&rmk91KZF092uLM7CO5MBKijWebalThibHT0C8o=uLM7CO5MBKijWebalThibHT0C8o=uLM7CO5MBKijWebalThibHT0C8o=uLM73',
            '0100194502876031213RhOJV25E&rmk91KZF092uLM7CO5MBKijWebalThibHT0C8o=uLM7CO5MBKijWebalThibHT0C8o=uLM7CO5MBKijWebalThibHT0C8o=uLM74',
            '0100194502876031213RhOJV25E&rmk91KZF092uLM7CO5MBKijWebalThibHT0C8o=uLM7CO5MBKijWebalThibHT0C8o=uLM7CO5MBKijWebalThibHT0C8o=uLM75',
            '0100194502876031213RhOJV25E&rmk91KZF092uLM7CO5MBKijWebalThibHT0C8o=uLM7CO5MBKijWebalThibHT0C8o=uLM7CO5MBKijWebalThibHT0C8o=uLM76',
            '0100194502876031213RhOJV25E&rmk91KZF092uLM7CO5MBKijWebalThibHT0C8o=uLM7CO5MBKijWebalThibHT0C8o=uLM7CO5MBKijWebalThibHT0C8o=uLM77',
            '0100194502876031213RhOJV25E&rmk91KZF092uLM7CO5MBKijWebalThibHT0C8o=uLM7CO5MBKijWebalThibHT0C8o=uLM7CO5MBKijWebalThibHT0C8o=uLM78',
            '0100194502876031213RhOJV25E&rmk91KZF092uLM7CO5MBKijWebalThibHT0C8o=uLM7CO5MBKijWebalThibHT0C8o=uLM7CO5MBKijWebalThibHT0C8o=uLM79',
            '0100194502876031213RhOJV25E&rmk91KZF092uLM7CO5MBKijWebalThibHT0C8o=uLM7CO5MBKijWebalThibHT0C8o=uLM7CO5MBKijWebalThibHT0C8o=uLM710',
            '0100194502876031213RhOJV25E&rmk91KZF092uLM7CO5MBKijWebalThibHT0C8o=uLM7CO5MBKijWebalThibHT0C8o=uLM7CO5MBKijWebalThibHT0C8o=uLM711',
        ];
//    $codes = $request->input('codes');
        if($codes == null){
            return response()->json(['message' => 'Error', 'code' => '202']);
        }
        $dataGs1 = array();
        foreach ($codes as $code){
            $dataGs1[] =  base64_encode(GS1DataMatrixTemplateService::template1(base64_decode($code)));
        }
        return response()->json(['data' => $dataGs1]);
    }
}
