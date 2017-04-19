<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ElecChargeController extends Controller
{
    public function indexPage(){
        return view('backend/elecCharge/index');
    }

    public function editPage(){
        return view('backend/elecCharge/edit');
    }

    public function addPage(){
        return view('backend/elecCharge/add');
    }
}
