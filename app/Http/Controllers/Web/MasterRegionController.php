<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterRegionController extends Controller
{
    //
    public function getSelect2Region(Request $request)
    {
        $query = \App\Models\Region::select(
            DB::raw('region AS id'),
            DB::raw("region AS text")
        );

        return get_select2_data($request, $query);
    }
}
