<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Article as Article;

class HomeController extends Controller
{



//    public function partOne(Request $request)
//    {
//        $beginDate = $request->beginDate;
//        $endDate = $request->endDate;
//        $pageNumber = $request->input('pageNumber', '1');
//        $size = $this->pageCount;
//
//        $skip = ($pageNumber - 1) * $size;
//        $data = Article::where('user_id', 1)
//            ->orderBy('created_at', 'desc')
//            ->skip($skip)
//            ->take($size)
//            ->get();
//
//        $totalCount = Article::where('user_id', 1)->count();
//
//        $floor = floor($totalCount/$size);
//        $pageCount = ($totalCount%$size == 0) ? $floor : ($floor + 1);
//
//        return view('backend.cel-unserv-event-list', [
//            'begin_date' => $beginDate,
//            'end_date' => $endDate,
//            'page_number' => $pageNumber,
//            'page_count' => $pageCount,
//            'total_count' => $totalCount,
//            'list' => $data,
//        ]);
//    }
}
