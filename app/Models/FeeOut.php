<?php
/**
 * Created by PhpStorm.
 * User: xv
 * Date: 2016/10/8
 * Time: 下午2:54
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Log;

class FeeOut extends Model
{
    protected $table = 'fee_out';


    private function getGnrQuery()
    {
        return DB::table('fee_out_gnr')->join('site_info', 'fee_out_gnr.site_code', '=', 'site_info.site_code')
            ->join('fee_out', 'fee_out_gnr.out_id', '=', 'fee_out.id')
            ->select(DB::raw('fee_out_gnr.id,fee_out_gnr.site_code, fee_out_gnr.gnr_start_time, fee_out_gnr.gnr_stop_time,fee_out_gnr.gnr_len,
             fee_out_gnr.gnr_compute_len,fee_out_gnr.gnr_fee,fee_out_gnr.gnr_fee_taxed,fee_out_gnr.created_at,fee_out_gnr.out_id,
             site_info.region_name,site_info.city_name,fee_out.is_out'));
    }

    /**
     * 查询所有的未出账记录
     */
    public function getFreeGnrList($region, $beginDay = '', $endDay = '')
    {
//        $query = $this->getGnrQuery()
//            ->where('site_info.region_name', $region)->where('out_id', 0);
//        if ($beginDay != '') {
//            $query->where('fee_out_gnr.gnr_start_time', '>=', $beginDay . '-01 00:00:00');
//        }
//        if ($endDay != '') {
//            $query->where('fee_out_gnr.gnr_start_time', '<=', $endDay . '-31 23:59:59');
//        }
//        return $query->orderBy('fee_out_gnr.created_at', 'asc')->get();
        return $query = DB::table('fee_out_site')
            ->where('region_name', $region)
            ->where('start_day', $beginDay)
            ->get();
    }

    public function getFreeGnrFees($region, $beginDay = '', $endDay = '')
    {
        if ($region != '湖北省') {
            $query = DB::table('fee_out_gnr')->join('site_info', 'fee_out_gnr.site_code', '=', 'site_info.site_code')
                ->select(DB::raw('ifnull(sum(gnr_fee), 0) as gnr_sum, count(gnr_fee) as gnr_count'))
                ->where('site_info.region_name', $region)->where('out_id', 0);
        } else {
            $query = DB::table('fee_out_gnr')->join('site_info', 'fee_out_gnr.site_code', '=', 'site_info.site_code')
                ->select(DB::raw('ifnull(sum(gnr_fee), 0) as gnr_sum, count(gnr_fee) as gnr_count'))
                ->where('out_id', 0);
        }

        if ($beginDay != '') {
            $query->where('fee_out_gnr.gnr_start_time', '>=', $beginDay . '-01 00:00:00');
        }
        if ($endDay != '') {
            $query->where('fee_out_gnr.gnr_start_time', '<=', $endDay . '-31 23:59:59');
        }
        return $query->first();
    }

    public function getBillGnrList($regionName, $month)
    {
        return $query = DB::table('fee_out_gnr')
            ->where('region_name', $regionName)
            ->where('gnr_result', '!=', '待处理')
            ->where('gnr_stop_time', '<=', $month[0].'-31'.' '.'23:59:59')
            ->where('gnr_start_time', '>=', $month[0].'-01'.' '.'00:00:00')
            ->get();



//        return $query = DB::table('fee_out_gnr')
//            ->where('out_id', $outId)
//            ->get();

//        $region = DB::table('fee_out')->where('id', $outId)->pluck('region_name');
//        $startDay = DB::table('fee_out')->where('id', $outId)->pluck('start_day');
//        $endDay = DB::table('fee_out')->where('id', $outId)->pluck('end_day');
//        $startDay = $startDay[0] . '-' . '1' . ' ' . '12:00:00';
//        $endDay = $endDay[0] . '-' . '31' . ' ' . '23:59:59';
//
//
////        $startDay = strtotime($startDay);
////        $endDay = strtotime($endDay);
//        $gnrRecs = DB::table('fee_out_gnr')->where('region_name', $region)->where('gnr_start_time', '>=', $startDay)->where('gnr_stop_time', '<=', $endDay);
//        return $gnrRecs->get();
//        return $this->getGnrQuery()->where('fee_out_gnr.out_id', $outId)->get();
    }

    public function getFeeOuts($region, $beginDay, $endDay, $out)
    {
        if ($region != '湖北省') {
            $query = self::where('region_name', $region)->where('is_out', $out);
        } else {
            $query = self::where('is_out', $out);
        }


        if ($beginDay != '') {
            $query->where('start_day', '>=', $beginDay);
        }
        if ($endDay != '') {
            $query->where('end_day', '<=', $endDay);
        }
        return $query->get();
    }

    public function attachGnrToBill($outId, $region, $beginDay, $endDay)
    {
        $list = $this::getFreeGnrList($region, $beginDay, $endDay);
        $now = date('Y-m-d H:i:s', time());
        foreach ($list as $gnr) {
            DB::table('fee_out_gnr')->where('id', $gnr->id)->update(['out_id' => $outId, 'updated_at' => $now]);
        }
    }

    private function getSitePrice($region)
    {
        return DB::table('fee_out_site_price')->join('site_info', 'fee_out_site_price.site_code', '=', 'site_info.site_code')
            ->select(DB::raw('fee_out_site_price.site_code,fee_out_site_price.fee_basic,fee_out_site_price.fee_basic_taxed,
              fee_out_site_price.fee_site,fee_out_site_price.fee_site_taxed,
              fee_out_site_price.fee_import,fee_out_site_price.fee_import_taxed'))
            ->where('site_info.region_name', $region)
            ->get();
    }

    public function attachSiteToBill($outId, $user, $region, $beginDay, $endDay)
    {
        // 计算终止日期和起始日期之间的相差月份，作为计费的乘法系数
        $tags = '-';
        $beginDay = explode($tags, $beginDay);
        $endDay = explode($tags, $endDay);
        $factor = abs($beginDay[0] - $endDay[0]) * 12 + ($endDay[1] - $beginDay[1]);


        $now = date('Y-m-d H:i:s', time());
        $list = $this::getSitePrice($region);
        foreach ($list as $p) {
            DB::insert('insert into fee_out_site (out_id,site_code,start_day,end_day,fee_basic,fee_basic_taxed,
              fee_site,fee_site_taxed,fee_import,fee_import_taxed,operator,created_at,updated_at) values (?,?,?,?,?,?,?,?,?,?,?,?,?)',
                [$outId, $p->site_code, $beginDay, $endDay, $p->fee_basic, $p->fee_basic_taxed,
                    $p->fee_site, $p->fee_site_taxed, $p->fee_import, $p->fee_import_taxed, $user, $now, $now]);
        }
    }

    public function updateBill($outId)
    {
        $fee_site = DB::table('fee_out_site')
            ->select(DB::raw('(sum(fee_basic)+sum(fee_site)+sum(fee_import)) as fee_site_sum'))
            ->where('out_id', $outId)
            ->first();
        if (empty($fee_site)) {
            $fee_site = 0;
        } else {
            $fee_site = $fee_site->fee_site_sum;
        }

        $fee_gnr = DB::table('fee_out_gnr')
            ->select(DB::raw('sum(gnr_fee) as fee_gnr_sum'))
            ->where('out_id', $outId)
            ->first();
        if (empty($fee_gnr)) {
            $fee_gnr = 0;
        } else {
            $fee_gnr = $fee_gnr->fee_gnr_sum;
        }
        DB::table('fee_out')->where('id', $outId)->update(['fee_gnr' => $fee_gnr, 'fee_site' => $fee_site]);

    }

    public function getBillSites($region, $month)
    {
//        return DB::table('fee_out_site')->where('region_name', $bill->region_name)->where('start_day', $bill->start_day)->
//        where('end_day', $bill->end_day)->orderBy('site_code', 'asc')->get();
        return DB::table('fee_out_site')
            ->where('region_name', $region)
            ->where('start_day', $month);
    }

    public function getDeduction1($region, $month)
    {
        return DB::table('single_site_fine')
            ->where('region_name', $region)
            ->where('month', $month)
            ->get();
    }

    public function getDeduction2($region, $month)
    {
        return DB::table('deduction_info')
            ->where('region_name', $region)
            ->where('month', $month)
            ->get();
    }
}