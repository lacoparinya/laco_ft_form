<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\FtLog;

class AutoImportController extends Controller
{
    public function test(){
        Excel::selectSheets('งานคัด')->load('storage/tmp/Report 11.2018.xlsx', function ($reader) {

            $results = $reader->get();
            dd($results);

        });
    }
}
