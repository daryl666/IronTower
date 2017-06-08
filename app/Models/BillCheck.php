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
        $telecomBills = $feeOutDB->getFeeOuts($region, $month, $month, 0);
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
        return array($ironTowerBills, $telecomBills);

    }


    public function getDiffOrders($month, $region)
    {
//        $teacher_student_first = DB::table('teacher')
//            ->leftJoin('student', 'student.teacher_id', '=', 'teacher.id')
//            ->select(DB::raw('student.id as student_id, student.teacher_id, student.name as student_name, teacher.name as teacher_name, teacher.id as teacher_id'));
//        $student_ids = $teacher_student_first->pluck('student_id');
//
//        $teacher_student_second = DB::table('student')
//            ->leftJoin('teacher', 'student.teacher_id', '=', 'teacher.id')
//            ->whereNotIn('student.id', array_filter($student_ids))
//            ->unionAll($teacher_student_first)
//            ->select(DB::raw('student.id as student_id, student.teacher_id, student.name as student_name, teacher.name as teacher_name, teacher.id as teacher_id'))
//            ->get();

        $telecomOrders = FeeOutSite::leftJoin('site_info', 'site_info.business_code', '=', 'fee_out_site.business_code')
            ->leftJoin('irontower_bill_detail', 'fee_out_site.business_code', '=', 'irontower_bill_detail.business_code')
            ->where('fee_out_site.start_day', $month)
            ->where('site_info.is_valid', 1)
            ->where('fee_out_site.region_id', transRegion($region))
            ->select(DB::raw('fee_out_site.id as fos_id, fee_out_site.out_id as fos_out_id, fee_out_site.region_id as region_id, fee_out_site.region_name as region_name, fee_out_site.business_code as business_code, fee_out_site.req_code as req_code, fee_out_site.site_code as site_code, fee_out_site.start_day as month, fee_out_site.fee_tower as fee_tower_fos, fee_out_site.fee_house as fee_house_fos, fee_out_site.fee_support as fee_support_fos, fee_out_site.fee_maintain as fee_maintain_fos, fee_out_site.fee_site as fee_site_fos, fee_out_site.fee_import as fee_import_fos, fee_out_site.fee_gnr_allincharge as fee_gnr_allincharge_fos, fee_out_site.fee_wlan as fee_wlan_fos, fee_out_site.fee_microwave as fee_microwave_fos, fee_out_site.fee_add as fee_add_fos, fee_out_site.fee_battery as fee_battery_fos, fee_out_site.fee_bbu as fee_bbu_fos, fee_out_site.fee_service as fee_service_fos, 
            
            site_info.id as si_id, site_info.site_name as site_name, site_info.product_type as product_type_si, site_info.tower_type as tower_type_si, site_info.sys_num1 as sys_num1_si, site_info.sys_num2 as sys_num2_si, site_info.sys_num3 as sys_num3_si, site_info.sys1_height as sys1_height_si, site_info.sys2_height as sys2_height_si, site_info.sys3_height as sys3_height_si, site_info.is_co_opetition as is_co_opetition_si, site_info.share_num_house as share_num_house_si, site_info.user1_rent_house_date as user1_rent_house_date_si, site_info.user2_rent_house_date as user2_rent_house_date_si, site_info.share_num_tower as share_num_tower_si, site_info.user1_rent_tower_date as user1_rent_tower_date_si, site_info.user2_rent_tower_date as user2_rent_tower_date_si, site_info.share_num_support as share_num_support_si, site_info.user1_rent_support_date as user1_rent_support_date_si, site_info.user2_rent_support_date as user2_rent_support_date_si, site_info.share_num_maintain as share_num_maintain_si, site_info.user1_rent_maintain_date as user1_rent_maintain_date_si, site_info.user2_rent_maintain_date as user2_rent_maintain_date_si, site_info.share_num_site as share_num_site_si, site_info.user1_rent_site_date as user1_rent_site_date_si, site_info.user2_rent_site_date as user2_rent_site_date_si, site_info.share_num_import as share_num_import_si, site_info.user1_rent_import_date as user1_rent_import_date_si, site_info.user2_rent_import_date as user2_rent_import_date_si, site_info.fee_wlan as fee_wlan_si, site_info.fee_microwave as fee_microwave_si, site_info.fee_add as fee_add_si, site_info.fee_battery as fee_battery_si, site_info.fee_bbu as fee_bbu_si, site_info.established_time as established_time_si, 
            
            irontower_bill_detail.id as ibd_id, irontower_bill_detail.product_type as product_type_ibd, irontower_bill_detail.tower_type as tower_type_ibd, irontower_bill_detail.sys_num1 as sys_num1_ibd, irontower_bill_detail.sys_num2 as sys_num2_ibd, irontower_bill_detail.sys_num3 as sys_num3_ibd, irontower_bill_detail.sys1_height as sys1_height_ibd, irontower_bill_detail.sys2_height as sys2_height_ibd, irontower_bill_detail.sys3_height as sys3_height_ibd, irontower_bill_detail.share_num_house as share_num_house_ibd, irontower_bill_detail.user1_rent_house_date as user1_rent_house_date_ibd, irontower_bill_detail.user2_rent_house_date as user2_rent_house_date_ibd, irontower_bill_detail.share_num_tower as share_num_tower_ibd, irontower_bill_detail.user1_rent_tower_date as user1_rent_tower_date_ibd, irontower_bill_detail.user2_rent_tower_date as user2_rent_tower_date_ibd, irontower_bill_detail.share_num_support as share_num_support_ibd, irontower_bill_detail.user1_rent_support_date as user1_rent_support_date_ibd, irontower_bill_detail.user2_rent_support_date as user2_rent_support_date_ibd, irontower_bill_detail.share_num_maintain as share_num_maintain_ibd, irontower_bill_detail.user1_rent_maintain_date as user1_rent_maintain_date_ibd, irontower_bill_detail.user2_rent_maintain_date as user2_rent_maintain_date_ibd, irontower_bill_detail.share_num_site as share_num_site_ibd, irontower_bill_detail.user1_rent_site_date as user1_rent_site_date_ibd, irontower_bill_detail.user2_rent_site_date as user2_rent_site_date_ibd, irontower_bill_detail.share_num_import as share_num_import_ibd, irontower_bill_detail.user1_rent_import_date as user1_rent_import_date_ibd, irontower_bill_detail.user2_rent_import_date as user2_rent_import_date_ibd, irontower_bill_detail.fee_wlan as fee_wlan_ibd, irontower_bill_detail.fee_microwave as fee_microwave_ibd, irontower_bill_detail.fee_add as fee_add_ibd, irontower_bill_detail.fee_battery as fee_battery_ibd, irontower_bill_detail.fee_bbu as fee_bbu_ibd, irontower_bill_detail.established_time as established_time_ibd, irontower_bill_detail.fee_house_discounted as fee_house_ibd, irontower_bill_detail.fee_tower_discounted as fee_tower_ibd, irontower_bill_detail.fee_support_discounted as fee_support_ibd, irontower_bill_detail.fee_maintain_discounted as fee_maintain_ibd, irontower_bill_detail.fee_site_discounted as fee_site_ibd, irontower_bill_detail.fee_import_discounted as fee_import_ibd, irontower_bill_detail.fee_wlan as fee_wlan_ibd, irontower_bill_detail.fee_microwave as fee_microwave_ibd, irontower_bill_detail.fee_add as fee_add_ibd, irontower_bill_detail.fee_battery as fee_battery_ibd, irontower_bill_detail.fee_bbu as fee_bbu_ibd, irontower_bill_detail.fee_gnr_allincharge as fee_gnr_allincharge_ibd'));
        $telecomBusinessCodes = $telecomOrders->get()->unique('business_code')->pluck('business_code')
        ->filter(function ($item) {
            return $item != null;
        });
        $orders = IronTowerBillDetail::where('irontower_bill_detail.month', $month)
            ->where('irontower_bill_detail.region_id', transRegion($region))
            ->leftJoin('fee_out_site', 'irontower_bill_detail.business_code', '=', 'fee_out_site.business_code')
            ->leftJoin('site_info', 'irontower_bill_detail.business_code', '=', 'site_info.business_code')
            ->whereNotIn('irontower_bill_detail.business_code', $telecomBusinessCodes)
            ->unionAll($telecomOrders)
            ->select(DB::raw('fee_out_site.id as fos_id, fee_out_site.out_id as fos_out_id, fee_out_site.region_id as region_id, fee_out_site.region_name as region_name, fee_out_site.business_code as business_code, fee_out_site.req_code as req_code, fee_out_site.site_code as site_code, fee_out_site.start_day as month, fee_out_site.fee_tower as fee_tower_fos, fee_out_site.fee_house as fee_house_fos, fee_out_site.fee_support as fee_support_fos, fee_out_site.fee_maintain as fee_maintain_fos, fee_out_site.fee_site as fee_site_fos, fee_out_site.fee_import as fee_import_fos, fee_out_site.fee_gnr_allincharge as fee_gnr_allincharge_fos, fee_out_site.fee_wlan as fee_wlan_fos, fee_out_site.fee_microwave as fee_microwave_fos, fee_out_site.fee_add as fee_add_fos, fee_out_site.fee_battery as fee_battery_fos, fee_out_site.fee_bbu as fee_bbu_fos, fee_out_site.fee_service as fee_service_fos, 
            
            site_info.id as si_id, site_info.site_name as site_name, site_info.product_type as product_type_si, site_info.tower_type as tower_type_si, site_info.sys_num1 as sys_num1_si, site_info.sys_num2 as sys_num2_si, site_info.sys_num3 as sys_num3_si, site_info.sys1_height as sys1_height_si, site_info.sys2_height as sys2_height_si, site_info.sys3_height as sys3_height_si, site_info.is_co_opetition as is_co_opetition_si, site_info.share_num_house as share_num_house_si, site_info.user1_rent_house_date as user1_rent_house_date_si, site_info.user2_rent_house_date as user2_rent_house_date_si, site_info.share_num_tower as share_num_tower_si, site_info.user1_rent_tower_date as user1_rent_tower_date_si, site_info.user2_rent_tower_date as user2_rent_tower_date_si, site_info.share_num_support as share_num_support_si, site_info.user1_rent_support_date as user1_rent_support_date_si, site_info.user2_rent_support_date as user2_rent_support_date_si, site_info.share_num_maintain as share_num_maintain_si, site_info.user1_rent_maintain_date as user1_rent_maintain_date_si, site_info.user2_rent_maintain_date as user2_rent_maintain_date_si, site_info.share_num_site as share_num_site_si, site_info.user1_rent_site_date as user1_rent_site_date_si, site_info.user2_rent_site_date as user2_rent_site_date_si, site_info.share_num_import as share_num_import_si, site_info.user1_rent_import_date as user1_rent_import_date_si, site_info.user2_rent_import_date as user2_rent_import_date_si, site_info.fee_wlan as fee_wlan_si, site_info.fee_microwave as fee_microwave_si, site_info.fee_add as fee_add_si, site_info.fee_battery as fee_battery_si, site_info.fee_bbu as fee_bbu_si, site_info.established_time as established_time_si, 
            
            irontower_bill_detail.id as ibd_id, irontower_bill_detail.product_type as product_type_ibd, irontower_bill_detail.tower_type as tower_type_ibd, irontower_bill_detail.sys_num1 as sys_num1_ibd, irontower_bill_detail.sys_num2 as sys_num2_ibd, irontower_bill_detail.sys_num3 as sys_num3_ibd, irontower_bill_detail.sys1_height as sys1_height_ibd, irontower_bill_detail.sys2_height as sys2_height_ibd, irontower_bill_detail.sys3_height as sys3_height_ibd, irontower_bill_detail.share_num_house as share_num_house_ibd, irontower_bill_detail.user1_rent_house_date as user1_rent_house_date_ibd, irontower_bill_detail.user2_rent_house_date as user2_rent_house_date_ibd, irontower_bill_detail.share_num_tower as share_num_tower_ibd, irontower_bill_detail.user1_rent_tower_date as user1_rent_tower_date_ibd, irontower_bill_detail.user2_rent_tower_date as user2_rent_tower_date_ibd, irontower_bill_detail.share_num_support as share_num_support_ibd, irontower_bill_detail.user1_rent_support_date as user1_rent_support_date_ibd, irontower_bill_detail.user2_rent_support_date as user2_rent_support_date_ibd, irontower_bill_detail.share_num_maintain as share_num_maintain_ibd, irontower_bill_detail.user1_rent_maintain_date as user1_rent_maintain_date_ibd, irontower_bill_detail.user2_rent_maintain_date as user2_rent_maintain_date_ibd, irontower_bill_detail.share_num_site as share_num_site_ibd, irontower_bill_detail.user1_rent_site_date as user1_rent_site_date_ibd, irontower_bill_detail.user2_rent_site_date as user2_rent_site_date_ibd, irontower_bill_detail.share_num_import as share_num_import_ibd, irontower_bill_detail.user1_rent_import_date as user1_rent_import_date_ibd, irontower_bill_detail.user2_rent_import_date as user2_rent_import_date_ibd, irontower_bill_detail.fee_wlan as fee_wlan_ibd, irontower_bill_detail.fee_microwave as fee_microwave_ibd, irontower_bill_detail.fee_add as fee_add_ibd, irontower_bill_detail.fee_battery as fee_battery_ibd, irontower_bill_detail.fee_bbu as fee_bbu_ibd, irontower_bill_detail.established_time as established_time_ibd, irontower_bill_detail.fee_house_discounted as fee_house_ibd, irontower_bill_detail.fee_tower_discounted as fee_tower_ibd, irontower_bill_detail.fee_support_discounted as fee_support_ibd, irontower_bill_detail.fee_maintain_discounted as fee_maintain_ibd, irontower_bill_detail.fee_site_discounted as fee_site_ibd, irontower_bill_detail.fee_import_discounted as fee_import_ibd, irontower_bill_detail.fee_wlan as fee_wlan_ibd, irontower_bill_detail.fee_microwave as fee_microwave_ibd, irontower_bill_detail.fee_add as fee_add_ibd, irontower_bill_detail.fee_battery as fee_battery_ibd, irontower_bill_detail.fee_bbu as fee_bbu_ibd, irontower_bill_detail.fee_gnr_allincharge as fee_gnr_allincharge_ibd'))->get()->unique('business_code');
        foreach ($orders as $index => $order) {
            if ((compareOrderDetail($order->established_time_si, $order->established_time_ibd) && compareOrderDetail($order->tower_type_si, $order->tower_type_ibd) && compareOrderDetail($order->product_type_si, $order->product_type_ibd) && compareOrderDetail($order->sys_num1_si, $order->sys_num1_ibd) && compareOrderDetail($order->sys1_height_si, $order->sys1_height_ibd) && compareOrderDetail($order->sys_num2_si, $order->sys_num2_ibd) && compareOrderDetail($order->sys2_height_si, $order->sys2_height_ibd) && compareOrderDetail($order->sys_num3_si, $order->sys_num3_ibd) && compareOrderDetail($order->sys3_height_si, $order->sys3_height_ibd) && compareOrderDetail($order->share_num_tower_si, $order->share_num_tower_ibd) && compareOrderDetail($order->user1_rent_tower_date_si, $order->user1_rent_tower_date_ibd) && compareOrderDetail($order->user2_rent_tower_date_si, $order->user2_rent_tower_date_ibd) && compareOrderDetail($order->share_num_house_si, $order->share_num_house_ibd) && compareOrderDetail($order->user1_rent_house_date_si, $order->user1_rent_house_date_ibd) && compareOrderDetail($order->user2_rent_house_date_si, $order->user2_rent_house_date_ibd) && compareOrderDetail($order->share_num_support_si, $order->share_num_support_ibd) && compareOrderDetail($order->user1_rent_support_date_si, $order->user1_rent_support_date_ibd) && compareOrderDetail($order->user2_rent_support_date_si, $order->user2_rent_support_date_ibd) && compareOrderDetail($order->share_num_maintain_si, $order->share_num_maintain_ibd) && compareOrderDetail($order->user1_rent_maintain_date_si, $order->user1_rent_maintain_date_ibd) && compareOrderDetail($order->user2_rent_maintain_date_si, $order->user2_rent_maintain_date_ibd) && compareOrderDetail($order->share_num_site_si, $order->share_num_site_ibd) && compareOrderDetail($order->user1_rent_site_date_si, $order->user1_rent_site_date_ibd) && compareOrderDetail($order->user2_rent_site_date_si, $order->user2_rent_site_date_ibd) && compareOrderDetail($order->share_num_import_si, $order->share_num_import_ibd) && compareOrderDetail($order->user1_rent_import_date_si, $order->user1_rent_import_date_ibd) && compareOrderDetail($order->user2_rent_import_date_si, $order->user2_rent_import_date_ibd) && compareOrderDetail($order->fee_tower_fos, $order->fee_tower_ibd) && compareOrderDetail($order->fee_house_fos, $order->fee_house_ibd) && compareOrderDetail($order->fee_support_fos, $order->fee_support_ibd) && compareOrderDetail($order->fee_maintain_fos, $order->fee_maintain_ibd) && compareOrderDetail($order->fee_site_fos, $order->fee_site_ibd) && compareOrderDetail($order->fee_import_fos, $order->fee_import_ibd) && compareOrderDetail($order->fee_gnr_allincharge_fos, $order->fee_gnr_allincharge_ibd) && compareOrderDetail($order->fee_add_fos, $order->fee_add_ibd) && compareOrderDetail($order->fee_battery_fos, $order->fee_battery_ibd) && compareOrderDetail($order->fee_wlan_fos, $order->fee_wlan_ibd) && compareOrderDetail($order->fee_microwave_fos, $order->fee_microwave_ibd) && compareOrderDetail($order->fee_bbu_fos, $order->fee_bbu_ibd))) {
                unset($orders[$index]);
            }

        }
        return $orders;


//        $telecomOrders = DB::table('fee_out_site')
//            ->join('site_info', 'site_info.business_code', '=', 'fee_out_site.business_code')
//            ->where('fee_out_site.start_day', $month)
//            ->where('site_info.is_valid', 1)
//            ->where('fee_out_site.region_id', transRegion($region))
//            ->get();
//        $ironTowerOrders = DB::table('irontower_bill_detail')
//            ->where('month', $month)
//            ->where('region_id', transRegion($region))
//            ->get();
//        $orders = array();
//        foreach ($telecomOrders as $indexTelecom => $telecomOrder) {
//            foreach ($ironTowerOrders as $indexIronTower => $ironTowerOrder) {
//                if ($ironTowerOrder->business_code === $telecomOrder->business_code) {
//                    $ironTowerOrder->is_site_name_same = $telecomOrder->is_site_name_same = $telecomOrder->site_name === $ironTowerOrder->site_name;
//                    $ironTowerOrder->is_site_code_same = $telecomOrder->is_site_code_same = $telecomOrder->site_code === $ironTowerOrder->site_code;
//                    $ironTowerOrder->is_req_code_same = $telecomOrder->is_req_code_same = $telecomOrder->req_code === $ironTowerOrder->req_code;
//                    $ironTowerOrder->is_established_time_same = $telecomOrder->is_established_time_same = $telecomOrder->established_time === $ironTowerOrder->established_time;
//                    $ironTowerOrder->is_tower_type_same = $telecomOrder->is_tower_type_same = $telecomOrder->tower_type === $ironTowerOrder->tower_type;
//                    $ironTowerOrder->is_product_type_same = $telecomOrder->is_product_type_same = $telecomOrder->product_type === $ironTowerOrder->product_type;
//                    $ironTowerOrder->is_fee_gnr_allincharge_same = $telecomOrder->is_fee_gnr_allincharge_same = $telecomOrder->fee_gnr_allincharge === $ironTowerOrder->fee_gnr_allincharge;
//                    $ironTowerOrder->is_fee_add_same = $telecomOrder->is_fee_add_same = $telecomOrder->fee_add === $ironTowerOrder->fee_add;
//                    $ironTowerOrder->is_fee_battery_same = $telecomOrder->is_fee_battery_same = $telecomOrder->fee_battery === $ironTowerOrder->fee_battery;
//                    $ironTowerOrder->is_fee_wlan_same = $telecomOrder->is_fee_wlan_same = $telecomOrder->fee_wlan === $ironTowerOrder->fee_wlan;
//                    $ironTowerOrder->is_fee_microwave_same = $telecomOrder->is_fee_microwave_same = $telecomOrder->fee_microwave === $ironTowerOrder->fee_microwave;
//                    $ironTowerOrder->is_fee_bbu_same = $telecomOrder->is_fee_bbu_same = $telecomOrder->fee_bbu === $ironTowerOrder->fee_bbu;
//                    $ironTowerOrder->is_sys_num1_same = $telecomOrder->is_sys_num1_same = $telecomOrder->sys_num1 === $ironTowerOrder->sys_num1;
//                    $ironTowerOrder->is_sys1_height_same = $telecomOrder->is_sys1_height_same = $telecomOrder->sys1_height === $ironTowerOrder->sys1_height;
//                    $ironTowerOrder->is_sys_num2_same = $telecomOrder->is_sys_num2_same = $telecomOrder->sys_num2 === $ironTowerOrder->sys_num2;
//                    $ironTowerOrder->is_sys2_height_same = $telecomOrder->is_sys2_height_same = $telecomOrder->sys2_height === $ironTowerOrder->sys2_height;
//                    $ironTowerOrder->is_sys_num3_same = $telecomOrder->is_sys_num3_same = $telecomOrder->sys_num3 === $ironTowerOrder->sys_num3;
//                    $ironTowerOrder->is_sys3_height_same = $telecomOrder->is_sys3_height_same = $telecomOrder->sys3_height === $ironTowerOrder->sys3_height;
//                    $ironTowerOrder->is_share_num_tower_same = $telecomOrder->is_share_num_tower_same = $telecomOrder->share_num_tower === $ironTowerOrder->share_num_tower;
//                    $ironTowerOrder->is_user1_rent_tower_date_same = $telecomOrder->is_user1_rent_tower_date_same = $telecomOrder->user1_rent_tower_date === $ironTowerOrder->user1_rent_tower_date;
//                    $ironTowerOrder->is_user2_rent_tower_date_same = $telecomOrder->is_user2_rent_tower_date_same = $telecomOrder->user2_rent_tower_date === $ironTowerOrder->user2_rent_tower_date;
//                    $ironTowerOrder->is_fee_tower_same = $telecomOrder->is_fee_tower_same = $telecomOrder->fee_tower === $ironTowerOrder->fee_tower_discounted;
//                    $ironTowerOrder->is_share_num_house_same = $telecomOrder->is_share_num_house_same = $telecomOrder->share_num_house === $ironTowerOrder->share_num_house;
//                    $ironTowerOrder->is_user1_rent_house_date_same = $telecomOrder->is_user1_rent_house_date_same = $telecomOrder->user1_rent_house_date === $ironTowerOrder->user1_rent_house_date;
//                    $ironTowerOrder->is_user2_rent_house_date_same = $telecomOrder->is_user2_rent_house_date_same = $telecomOrder->user2_rent_house_date === $ironTowerOrder->user2_rent_house_date;
//                    $ironTowerOrder->is_fee_house_same = $telecomOrder->is_fee_house_same = $telecomOrder->fee_house === $ironTowerOrder->fee_house_discounted;
//                    $ironTowerOrder->is_share_num_support_same = $telecomOrder->is_share_num_support_same = $telecomOrder->share_num_support === $ironTowerOrder->share_num_support;
//                    $ironTowerOrder->is_user1_rent_support_date_same = $telecomOrder->is_user1_rent_support_date_same = $telecomOrder->user1_rent_support_date === $ironTowerOrder->user1_rent_support_date;
//                    $ironTowerOrder->is_user2_rent_support_date_same = $telecomOrder->is_user2_rent_support_date_same = $telecomOrder->user2_rent_support_date === $ironTowerOrder->user2_rent_support_date;
//                    $ironTowerOrder->is_fee_support_same = $telecomOrder->is_fee_support_same = $telecomOrder->fee_support === $ironTowerOrder->fee_support_discounted;
//                    $ironTowerOrder->is_share_num_maintain_same = $telecomOrder->is_share_num_maintain_same = $telecomOrder->share_num_maintain === $ironTowerOrder->share_num_maintain;
//                    $ironTowerOrder->is_user1_rent_maintain_date_same = $telecomOrder->is_user1_rent_maintain_date_same = $telecomOrder->user1_rent_maintain_date === $ironTowerOrder->user1_rent_maintain_date;
//                    $ironTowerOrder->is_user2_rent_maintain_date_same = $telecomOrder->is_user2_rent_maintain_date_same = $telecomOrder->user2_rent_maintain_date === $ironTowerOrder->user2_rent_maintain_date;
//                    $ironTowerOrder->is_fee_maintain_same = $telecomOrder->is_fee_maintain_same = $telecomOrder->fee_maintain === $ironTowerOrder->fee_maintain_discounted;
//                    $ironTowerOrder->is_share_num_site_same = $telecomOrder->is_share_num_site_same = $telecomOrder->share_num_site === $ironTowerOrder->share_num_site;
//                    $ironTowerOrder->is_user1_rent_site_date_same = $telecomOrder->is_user1_rent_site_date_same = $telecomOrder->user1_rent_site_date === $ironTowerOrder->user1_rent_site_date;
//                    $ironTowerOrder->is_user2_rent_site_date_same = $telecomOrder->is_user2_rent_site_date_same = $telecomOrder->user2_rent_site_date === $ironTowerOrder->user2_rent_site_date;
//                    $ironTowerOrder->is_fee_site_same = $telecomOrder->is_fee_site_same = $telecomOrder->fee_site === $ironTowerOrder->fee_site_discounted;
//                    $ironTowerOrder->is_share_num_import_same = $telecomOrder->is_share_num_import_same = $telecomOrder->share_num_import === $ironTowerOrder->share_num_import;
//                    $ironTowerOrder->is_user1_rent_import_date_same = $telecomOrder->is_user1_rent_import_date_same = $telecomOrder->user1_rent_import_date === $ironTowerOrder->user1_rent_import_date;
//                    $ironTowerOrder->is_user2_rent_import_date_same = $telecomOrder->is_user2_rent_import_date_same = $telecomOrder->user2_rent_import_date === $ironTowerOrder->user2_rent_import_date;
//                    $ironTowerOrder->is_fee_import_same = $telecomOrder->is_fee_import_same = $telecomOrder->fee_import === $ironTowerOrder->fee_import_discounted;
//                    $ironTowerOrder->is_fee_total_same = $telecomOrder->is_fee_total_same = $telecomOrder->fee_service === $ironTowerOrder->fee_total;
//                    $ironTowerOrder->is_is_new_tower_same = $telecomOrder->is_is_new_tower_same = $telecomOrder->is_new_tower === $ironTowerOrder->is_new_tower;
//                    array_push($orders, array('0' => $telecomOrder, '1' => $ironTowerOrder));
//                    unset($telecomOrders[$indexTelecom]);
//                    unset($ironTowerOrders[$indexIronTower]);
//                }
//            }
//        }
//        foreach ($telecomOrders as $telecomOrder) {
//            array_push($orders, array('0' => $telecomOrder, '1' => null));
//        }
//        foreach ($ironTowerOrders as $ironTowerOrder) {
//            array_push($orders, array('0' => null, '1' => $ironTowerOrder));
//        }
//        return $orders;
    }


}
