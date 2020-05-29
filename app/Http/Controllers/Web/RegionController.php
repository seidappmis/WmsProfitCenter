<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegionController extends Controller
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
