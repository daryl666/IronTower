<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;

class CustomPaginator extends Model
{
    public function paginate(Request $request, $items, $perPage)
    {
        if ($request->has('page')) {
            $currentPage = $request->input('page');
            $currentPage = $currentPage <= 0 ? 1 : $currentPage;
        } else {
            $currentPage = 1;
        }
        if (is_array($items)) {
            $item = array_slice($items, ($currentPage - 1) * $perPage, $perPage);
            $total = count($items);
        }else{
            $item = $items->slice(($currentPage - 1) * $perPage, $perPage);
            $total = $items->count();
        }



        $paginator = new LengthAwarePaginator($item, $total, $perPage, $currentPage, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);
        return $paginator;
    }
}
