<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\StudentExcelImport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function excelExtract(Request $request){
        error_log("Excel controller");
        $excelFile = request('excelFile');

        $array = Excel::toArray(new StudentExcelImport, $excelFile);
        //error_log(json_encode($array[0]));

        return $array[0];
    }
}
