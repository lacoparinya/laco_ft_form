<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FreezeM;
use App\FreezeD;

class ListingController extends Controller
{
    public function get_freeze_m_data($id){

        $freezem = FreezeM::findOrFail($id);

        return response()->json($freezem);
    }

    public function get_freeze_m_list($limit)
    {

        $freezems = FreezeM::latest()->limit($limit);

        return response()->json($freezems);
    }

    public function get_freeze_d_data($id)
    {

        $freezed = FreezeD::findOrFail($id);

        return response()->json($freezed);
    }

    public function get_freeze_d_list($pageNumber)
    {

        $limit = 5;
        $freezeds = FreezeD::latest()->paginate($limit, ['*'], 'page', $pageNumber);

        return response()->json($freezeds);
    }
}
