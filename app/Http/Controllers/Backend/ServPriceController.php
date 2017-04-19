<?php

namespace App\Http\Controllers\Backend;

use App\Models\ServPrice;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\SiteInfo;

class ServPriceController extends Controller
{
    public function indexPage(Request $request)
    {
        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
            $filter = $request->all();
            $region = $request->input('region', '');
            $servpriceDB = new ServPrice();
            $servPrices = $servpriceDB->searchServPrice($region);
            return view('backend/servPrice/index')->with('servPrices',$servPrices)
                ->with('filter',$filter);
        }
        elseif ($_SERVER['REQUEST_METHOD'] == "GET")
        {

            return view('backend/servPrice/index');
        }

    }
}
