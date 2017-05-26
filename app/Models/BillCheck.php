<?php

namespace App\Models;

use App\Http\Requests\Request;
use Illuminate\Database\Eloquent\Model;
use App\Models\IronTowerBillDetail;
use DB;
use PhpParser\Node\Expr\Cast\Object_;

class BillCheck extends Model
{

    public function getDiffBills($month, $region)
    {
        $feeOutDB = new FeeOut();
        $telecomBills = $feeOutDB->getFeeOuts($region, $month, $month, 1);
        if ($region == '湖北省') {
            $ironTowerBills = IronTowerBillDetail::select(DB::raw('month, region_id, sum(fee_gnr_allincharge) fee_gnr_allincharge, sum(fee_tower_discounted) fee_tower, sum(fee_house_discounted) fee_house, sum(fee_support_discounted) fee_support, sum(fee_maintain_discounted) fee_maintain, sum(fee_site_discounted) fee_site, sum(fee_import_discounted) fee_import, sum(fee_total) fee_total'))
                ->where('month', $month)
                ->groupBy('region_id')
                ->get();
        } else {
            $ironTowerBills = IronTowerBillDetail::select(DB::raw('month, region_id, sum(fee_gnr_allincharge) fee_gnr_allincharge, sum(fee_tower_discounted) fee_tower, sum(fee_house_discounted) fee_house, sum(fee_support_discounted) fee_support, sum(fee_maintain_discounted) fee_maintain, sum(fee_site_discounted) fee_site, sum(fee_import_discounted) fee_import, sum(fee_total) fee_total'))
                ->where('month', $month)
                ->where('region_id', transRegion($region))
                ->get();
        }
        foreach ($telecomBills as $telecomBill) {
            foreach ($ironTowerBills as $ironTowerBill) {
                if ($telecomBill->month == $ironTowerBill->month && $ironTowerBill->region_id == $telecomBill->region_id) {
                    $telecomBill->is_fee_tower_same = $telecomBill->fee_tower === $ironTowerBill->fee_tower;
                    $telecomBill->is_fee_house_same = $telecomBill->fee_house === $ironTowerBill->fee_house;
                    $telecomBill->is_fee_support_same = $telecomBill->fee_support === $ironTowerBill->fee_support;
                    $telecomBill->is_fee_maintain_same = $telecomBill->fee_maintain === $ironTowerBill->fee_maintain;
                    $telecomBill->is_fee_site_same = $telecomBill->fee_site === $ironTowerBill->fee_site;
                    $telecomBill->is_fee_import_same = $telecomBill->fee_import === $ironTowerBill->fee_import;
                    $telecomBill->is_fee_total_same = $telecomBill->fee_total_allincharge === $ironTowerBill->fee_total;
                }
            }
        }
//        dd($ironTowerBills);
        return array($ironTowerBills, $telecomBills);

    }


    public function getDiffOrders($month, $region)
    {
        $telecomOrders = DB::table('fee_out_site')
            ->join('site_info', 'site_info.business_code', '=', 'fee_out_site.business_code')
            ->where('fee_out_site.start_day', $month)
            ->where('site_info.is_valid', 1)
            ->where('fee_out_site.region_id', transRegion($region))
            ->get();
        $ironTowerOrders = DB::table('irontower_bill_detail')
            ->where('month', $month)
            ->where('region_id', transRegion($region))
            ->get();
        $orders = array();
        foreach ($telecomOrders as $indexTelecom => $telecomOrder) {
            foreach ($ironTowerOrders as $indexIronTower => $ironTowerOrder) {
                if ($ironTowerOrder->business_code === $telecomOrder->business_code) {
                    $ironTowerOrder->is_site_name_same = $telecomOrder->is_site_name_same = $telecomOrder->site_name === $ironTowerOrder->site_name;
                    $ironTowerOrder->is_site_code_same = $telecomOrder->is_site_code_same = $telecomOrder->site_code === $ironTowerOrder->site_code;
                    $ironTowerOrder->is_req_code_same = $telecomOrder->is_req_code_same = $telecomOrder->req_code === $ironTowerOrder->req_code;
                    $ironTowerOrder->is_established_time_same = $telecomOrder->is_established_time_same = $telecomOrder->established_time === $ironTowerOrder->established_time;
                    $ironTowerOrder->is_tower_type_same = $telecomOrder->is_tower_type_same = $telecomOrder->tower_type === $ironTowerOrder->tower_type;
                    $ironTowerOrder->is_product_type_same = $telecomOrder->is_product_type_same = $telecomOrder->product_type === $ironTowerOrder->product_type;
                    $ironTowerOrder->is_fee_gnr_allincharge_same = $telecomOrder->is_fee_gnr_allincharge_same = $telecomOrder->fee_gnr_allincharge === $ironTowerOrder->fee_gnr_allincharge;
                    $ironTowerOrder->is_fee_add_same = $telecomOrder->is_fee_add_same = $telecomOrder->fee_add === $ironTowerOrder->fee_add;
                    $ironTowerOrder->is_fee_battery_same = $telecomOrder->is_fee_battery_same = $telecomOrder->fee_battery === $ironTowerOrder->fee_battery;
                    $ironTowerOrder->is_fee_wlan_same = $telecomOrder->is_fee_wlan_same = $telecomOrder->fee_wlan === $ironTowerOrder->fee_wlan;
                    $ironTowerOrder->is_fee_microwave_same= $telecomOrder->is_fee_microwave_same= $telecomOrder->fee_microwave === $ironTowerOrder->fee_microwave;
                    $ironTowerOrder->is_fee_bbu_same = $telecomOrder->is_fee_bbu_same = $telecomOrder->fee_bbu === $ironTowerOrder->fee_bbu;
                    $ironTowerOrder->is_sys_num1_same = $telecomOrder->is_sys_num1_same = $telecomOrder->sys_num1 === $ironTowerOrder->sys_num1;
                    $ironTowerOrder->is_sys1_height_same = $telecomOrder->is_sys1_height_same = $telecomOrder->sys1_height === $ironTowerOrder->sys1_height;
                    $ironTowerOrder->is_sys_num2_same = $telecomOrder->is_sys_num2_same = $telecomOrder->sys_num2 === $ironTowerOrder->sys_num2;
                    $ironTowerOrder->is_sys2_height_same = $telecomOrder->is_sys2_height_same = $telecomOrder->sys2_height === $ironTowerOrder->sys2_height;
                    $ironTowerOrder->is_sys_num3_same = $telecomOrder->is_sys_num3_same = $telecomOrder->sys_num3 === $ironTowerOrder->sys_num3;
                    $ironTowerOrder->is_sys3_height_same = $telecomOrder->is_sys3_height_same = $telecomOrder->sys3_height === $ironTowerOrder->sys3_height;
                    $ironTowerOrder->is_share_num_tower_same = $telecomOrder->is_share_num_tower_same = $telecomOrder->share_num_tower === $ironTowerOrder->share_num_tower;
                    $ironTowerOrder->is_user1_rent_tower_date_same = $telecomOrder->is_user1_rent_tower_date_same = $telecomOrder->user1_rent_tower_date === $ironTowerOrder->user1_rent_tower_date;
                    $ironTowerOrder->is_user2_rent_tower_date_same = $telecomOrder->is_user2_rent_tower_date_same = $telecomOrder->user2_rent_tower_date === $ironTowerOrder->user2_rent_tower_date;
                    $ironTowerOrder->is_fee_tower_same = $telecomOrder->is_fee_tower_same = $telecomOrder->fee_tower === $ironTowerOrder->fee_tower_discounted;
                    $ironTowerOrder->is_share_num_house_same = $telecomOrder->is_share_num_house_same = $telecomOrder->share_num_house === $ironTowerOrder->share_num_house;
                    $ironTowerOrder->is_user1_rent_house_date_same = $telecomOrder->is_user1_rent_house_date_same = $telecomOrder->user1_rent_house_date === $ironTowerOrder->user1_rent_house_date;
                    $ironTowerOrder->is_user2_rent_house_date_same = $telecomOrder->is_user2_rent_house_date_same = $telecomOrder->user2_rent_house_date === $ironTowerOrder->user2_rent_house_date;
                    $ironTowerOrder->is_fee_house_same = $telecomOrder->is_fee_house_same = $telecomOrder->fee_house === $ironTowerOrder->fee_house_discounted;
                    $ironTowerOrder->is_share_num_support_same = $telecomOrder->is_share_num_support_same = $telecomOrder->share_num_support === $ironTowerOrder->share_num_support;
                    $ironTowerOrder->is_user1_rent_support_date_same = $telecomOrder->is_user1_rent_support_date_same = $telecomOrder->user1_rent_support_date === $ironTowerOrder->user1_rent_support_date;
                    $ironTowerOrder->is_user2_rent_support_date_same = $telecomOrder->is_user2_rent_support_date_same = $telecomOrder->user2_rent_support_date === $ironTowerOrder->user2_rent_support_date;
                    $ironTowerOrder->is_fee_support_same = $telecomOrder->is_fee_support_same = $telecomOrder->fee_support === $ironTowerOrder->fee_support_discounted;
                    $ironTowerOrder->is_share_num_maintain_same = $telecomOrder->is_share_num_maintain_same = $telecomOrder->share_num_maintain === $ironTowerOrder->share_num_maintain;
                    $ironTowerOrder->is_user1_rent_maintain_date_same = $telecomOrder->is_user1_rent_maintain_date_same = $telecomOrder->user1_rent_maintain_date === $ironTowerOrder->user1_rent_maintain_date;
                    $ironTowerOrder->is_user2_rent_maintain_date_same = $telecomOrder->is_user2_rent_maintain_date_same = $telecomOrder->user2_rent_maintain_date === $ironTowerOrder->user2_rent_maintain_date;
                    $ironTowerOrder->is_fee_maintain_same = $telecomOrder->is_fee_maintain_same = $telecomOrder->fee_maintain === $ironTowerOrder->fee_maintain_discounted;
                    $ironTowerOrder->is_share_num_site_same = $telecomOrder->is_share_num_site_same = $telecomOrder->share_num_site === $ironTowerOrder->share_num_site;
                    $ironTowerOrder->is_user1_rent_site_date_same = $telecomOrder->is_user1_rent_site_date_same = $telecomOrder->user1_rent_site_date === $ironTowerOrder->user1_rent_site_date;
                    $ironTowerOrder->is_user2_rent_site_date_same = $telecomOrder->is_user2_rent_site_date_same = $telecomOrder->user2_rent_site_date === $ironTowerOrder->user2_rent_site_date;
                    $ironTowerOrder->is_fee_site_same = $telecomOrder->is_fee_site_same = $telecomOrder->fee_site === $ironTowerOrder->fee_site_discounted;
                    $ironTowerOrder->is_share_num_import_same = $telecomOrder->is_share_num_import_same = $telecomOrder->share_num_import === $ironTowerOrder->share_num_import;
                    $ironTowerOrder->is_user1_rent_import_date_same = $telecomOrder->is_user1_rent_import_date_same = $telecomOrder->user1_rent_import_date === $ironTowerOrder->user1_rent_import_date;
                    $ironTowerOrder->is_user2_rent_import_date_same = $telecomOrder->is_user2_rent_import_date_same = $telecomOrder->user2_rent_import_date === $ironTowerOrder->user2_rent_import_date;
                    $ironTowerOrder->is_fee_import_same = $telecomOrder->is_fee_import_same = $telecomOrder->fee_import === $ironTowerOrder->fee_import_discounted;
                    $ironTowerOrder->is_fee_total_same = $telecomOrder->is_fee_total_same = $telecomOrder->fee_service === $ironTowerOrder->fee_total;
                    $ironTowerOrder->is_is_new_tower_same = $telecomOrder->is_is_new_tower_same = $telecomOrder->is_new_tower === $ironTowerOrder->is_new_tower;
                    array_push($orders, array('0' => $telecomOrder, '1' => $ironTowerOrder));
                    unset($telecomOrders[$indexTelecom]);
                    unset($ironTowerOrders[$indexIronTower]);
                }
            }
        }
        foreach ($telecomOrders as $telecomOrder) {
            array_push($orders, array('0' => $telecomOrder, '1' => null));
        }
        foreach ($ironTowerOrders as $ironTowerOrder) {
            array_push($orders, array('0' => null, '1' => $ironTowerOrder));
        }
        return $orders;
    }
}
