<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RentStdController extends Controller
{
    public function indexPage(){
        return view('backend/rentStd/index');
    }

    public function fee_std_search(Request $request){
        $filter = $request->all();
        $region = $request->get('region');
        if($request->get('fee_type')=='铁塔基准价格'){
            $tow_fees=DB::table('fee_tower_std')->get();
            return view('backend/rentStd/search_tow_fee',['tow_fees'=>$tow_fees, 'filter'=>$filter]);
        }
        else if($request->get('fee_type')=='机房基准价格'){
            $hou_fees=DB::table('fee_house_std')->get();
            return view('backend/rentStd/search_hou_fee',['hou_fees'=>$hou_fees, 'filter'=>$filter]);
        }
        else if($request->get('fee_type')=='配套基准价格'){
            $sup_fees=DB::table('fee_support_std')->get();
            return view('backend/rentStd/search_sup_fee',['sup_fees'=>$sup_fees, 'filter'=>$filter]);
        }
        else if($request->get('fee_type')=='维护费'){
            $main_fees=DB::table('fee_maintain_std')->get();
            return view('backend/rentStd/search_main_fee',['main_fees'=>$main_fees, 'filter'=>$filter]);
        }
        else if($request->get('fee_type')=='场地费'){
            if($region != '湖北省'){
                $site_fees=DB::table('fee_site_std')->where('region_name',$request->get('region'))->get();
            }else{
                $site_fees=DB::table('fee_site_std')->get();
            }
            return view('backend/rentStd/search_site_fee',['site_fees'=>$site_fees, 'filter'=>$filter]);
        }
        else if($request->get('fee_type')=='电力引入费'){
            if($region != '湖北省'){
                $elec_introduced_fees=DB::table('fee_import_std')->where('region_name',$request->get('region'))->get();
            }else{
                $elec_introduced_fees=DB::table('fee_import_std')->get();
            }

            return view('backend/rentStd/search_elec_introduced_fee',['elec_introduced_fees'=>$elec_introduced_fees, 'filter'=>$filter]);
        }
        else{
            $share_discounts=DB::table('share_discount_std')->get();
            return view('backend/rentStd/search_share_discount',['share_discounts'=>$share_discounts, 'filter'=>$filter]);
        }
    }

    public function basic_fee_update($seq,$region,$fee_type){
        $basic_fee=DB::table('fee_basic_table')->where('seq',$seq)->get();
        return view('backend/rentStd/update_basic_fee',['basic_fee'=>$basic_fee[0], 'region'=>$region, 'fee_type'=>$fee_type]);
    }

    public function site_fee_update($seq){
        $site_fee=DB::table('fee_site_std')->where('seq',$seq)->get();
        return view('backend/rentStd/update_site_fee',['site_fee'=>$site_fee[0]]);
    }

    public function elec_introduced_fee_update($seq){
        $elec_introduced_fee=DB::table('fee_import_std')->where('seq',$seq)->get();
        return view('backend/rentStd/update_elec_introduced_fee',['elec_introduced_fee'=>$elec_introduced_fee[0]]);
    }

    public function share_discount_update($seq){
        $share_discount=DB::table('share_discount_std')->where('seq',$seq)->get();
        return view('backend/rentStd/update_share_discount',['share_discount'=>$share_discount[0]]);
    }

    public function update_basic_fee(Request $request){
        DB::table('fee_basic_table')->where('product_type',$request->get('product_type'))->
        where('tower_type',$request->get('tower_type'))->where('sys_height',$request->get('sys_height'))->where('is_new_tower',$request->get('is_new_tower'))->
        update([
            'fee_basic'=>$request->get('fee_basic'),
        ]);
        echo "<script language=javascript>alert('修改成功！');history.back();</script>";
    }

    public function update_elec_introduced_fee(Request $request){
        DB::table('fee_import_std')->where('region_name',$request->get('region_name'))->
        where('elec_introduced_type',$request->get('elec_introduced_type'))->
        update([
            'fee_import'=>$request->get('fee_import'),
        ]);
        echo "<script language=javascript>alert('修改成功！');history.back();</script>";
    }
    public function update_site_fee(Request $request){
        DB::table('fee_site_std')->where('region_name',$request->get('region_name'))->
        where('site_district_type',$request->get('site_district_type'))->where('is_rru_away',$request->get('is_rru_away'))
            ->update([
                'fee_site'=>$request->get('fee_site'),
            ]);
        echo "<script language=javascript>alert('修改成功！');history.back();</script>";
    }

    public function update_share_discount(Request $request){
        DB::table('share_discount_std')->where('share_num',$request->get('share_num'))->
        where('user_type',$request->get('user_type'))->where('is_new_tower',$request->get('is_new_tower'))->where('is_newly_added',$request->get('is_newly_added'))->
        update([
            'discount_basic'=>$request->get('discount_basic'),
            'discount_site'=>$request->get('discount_site'),
            'discount_import'=>$request->get('discount_import'),
        ]);
        echo "<script language=javascript>alert('修改成功！');history.back();</script>";
    }

}
