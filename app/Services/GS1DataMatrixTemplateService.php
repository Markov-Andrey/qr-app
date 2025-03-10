<?php


namespace App\Services;


use Illuminate\Support\Str;

class GS1DataMatrixTemplateService
{

    public static function template1($code, $data = [])
    {

        $barcode = new GS1DataMatrixService();
        $sizeSvg = ['h' => 100, 'w' => 100];
        $svgBarcode = $barcode->createDataMatrix($code);


        $dataMatrix = ['svg' => $svgBarcode, 'x' => 4, 'y' => 4, 'scale' => 2];
        return $barcode->getSvgData($sizeSvg, $dataMatrix, $data);
    }



}
