<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\GnrRec;
use App\Models\IronTowerBillDetail;
use App\Models\ServCost;
use App\Models\SiteInfo;
use Auth;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use PHPExcel;

class ExcelController extends Controller
{
    public function exportSiteInfo(Request $request)
    {
        $region     = $request->get('region');
        $siteinfoDB = new SiteInfo();
        $infoSites  = $siteinfoDB->searchInfoSite($region)->get();
        foreach ($infoSites as $infoSite) {
            $export[] = array(
                '产品业务确认单编号'           => $infoSite->business_code,
                '站址编码'                => $infoSite->site_code,
                '站址名称'                => $infoSite->site_name,
                'C网网管编号'              => $infoSite->cdma_code,
                'L网网管编号'              => $infoSite->lte_code,
                '需求确认单编号'             => $infoSite->req_code,
                '地市'                  => $infoSite->region_name,
                '产品配套类型'              => transProductType($infoSite->product_type),
                '服务起始日期'              => $infoSite->established_time,
                '是否为新建站'              => transIsNewTower($infoSite->is_new_tower),
                '铁塔类型'                => transTowerType($infoSite->tower_type),
                '系统数量1'               => $infoSite->sys_num1,
                '系统1挂高'               => transSysHeight($infoSite->sys1_height),
                '系统数量2'               => $infoSite->sys_num2,
                '系统2挂高'               => transSysHeight($infoSite->sys2_height),
                '系统数量3'               => $infoSite->sys_num3,
                '系统3挂高'               => transSysHeight($infoSite->sys3_height),
                '站址位置'                => transLandForm($infoSite->land_form),
                '是否为竞合站点'             => transIsCoOpetition($infoSite->is_co_opetition),
                '机房共享用户数'             => transShareType($infoSite->share_num_house),
                '机房共享运营商1的起租日期'       => $infoSite->user1_rent_house_date,
                '机房共享运营商2的起租日期'       => $infoSite->user2_rent_house_date,
                '铁塔共享用户数'             => transShareType($infoSite->share_num_tower),
                '铁塔共享运营商1的起租日期'       => $infoSite->user1_rent_tower_date,
                '铁塔共享运营商2的起租日期'       => $infoSite->user2_rent_tower_date,
                '配套共享用户数'             => transShareType($infoSite->share_num_support),
                '配套共享运营商1的起租日期'       => $infoSite->user1_rent_support_date,
                '配套共享运营商2的起租日期'       => $infoSite->user2_rent_support_date,
                '维护费共享用户数'            => transShareType($infoSite->share_num_maintain),
                '维护费共享运营商1的起租日期'      => $infoSite->user1_rent_maintain_date,
                '维护费共享运营商2的起租日期'      => $infoSite->user2_rent_maintain_date,
                '场地费共享用户数'            => transShareType($infoSite->share_num_site),
                '场地费共享运营商1的起租日期'      => $infoSite->user1_rent_site_date,
                '场地费共享运营商2的起租日期'      => $infoSite->user2_rent_site_date,
                '电力引入费共享用户数'          => transShareType($infoSite->share_num_import),
                '电力引入费共享运营商1的起租日期'    => $infoSite->user1_rent_import_date,
                '电力引入费共享运营商2的起租日期'    => $infoSite->user2_rent_import_date,
                '覆盖场景'                => transSiteDistType($infoSite->site_district_type),
                'RRU是否拉远'             => transIsRRUAway($infoSite->is_rru_away),
                '用户类型'                => transUserType($infoSite->user_type),
                '引电类型'                => transElecType($infoSite->elec_introduced_type),
                'WLAN费用'              => $infoSite->fee_wlan,
                '微波费用'                => $infoSite->fee_microwave,
                '超过10%高等级服务站址额外维护服务费' => $infoSite->fee_add,
                '蓄电池额外保障费'            => $infoSite->fee_battery,
                'bbu安装在铁塔机房费'         => $infoSite->fee_bbu,
            );
        }
        Excel::create('站址属性信息', function ($excel) use ($export) {
            $excel->sheet('站址属性信息', function ($sheet) use ($export) {
                $sheet->fromArray($export);
            });
        })->export('xls');
    }

    public function exportServCost(Request $request)
    {
        $region     = $request->get('region');
        $beginDate  = $request->get('beginDate');
        $endDate    = $request->get('endDate');
        $servCostDB = new ServCost();
        $servCosts  = $servCostDB->searchServCost($region, $beginDate, $endDate);
        if (!empty($servCosts)) {
            foreach ($servCosts as $servCost) {
                if (!isset($servCost->fee_basic)) {
                    $servCost->fee_basic = '';
                }
                if (!isset($servCost->fee_basic_taxed)) {
                    $servCost->fee_basic_taxed = '';
                }
                if (!isset($servCost->fee_site)) {
                    $servCost->fee_site = '';
                }
                if (!isset($servCost->fee_site_taxed)) {
                    $servCost->fee_site_taxed = '';
                }
                if (!isset($servCost->fee_import)) {
                    $servCost->fee_import = '';
                }
                if (!isset($servCost->fee_import_taxed)) {
                    $servCost->fee_import_taxed = '';
                }
                if (!isset($servCost->fee_electricity)) {
                    $servCost->fee_electricity = '';
                }
                if (!isset($servCost->fee_electricity_taxed)) {
                    $servCost->fee_electricity_taxed = '';
                }
                $export[] = array(
                    '地市'            => $servCost->region_name,
                    '提交时间'          => $servCost->created_at,
                    '服务费用日期'        => $servCost->month,
                    '站址总数'          => $servCost->site_num,
                    '基准价格（万元/不含税）'  => $servCost->fee_basic,
                    '基准价格（万元/含税）'   => $servCost->fee_basic_taxed,
                    '场地费（万元/不含税）'   => $servCost->fee_site,
                    '场地费（万元/含税）'    => $servCost->fee_site_taxed,
                    '电力引入费（万元/不含税）' => $servCost->fee_import,
                    '电力引入费（万元/含税）'  => $servCost->fee_import_taxed,
                    '日常电费（万元/不含税）'  => $servCost->fee_electricity,
                    '日常电费（万元/含税）'   => $servCost->fee_electricity_taxed,

                );
            }
            Excel::create('站址服务费用', function ($excel) use ($export) {
                $excel->sheet('站址服务费用', function ($sheet) use ($export) {
                    $sheet->fromArray($export);
                });
            })->export('xls');
        } else {
            echo "<script>history.back()</script>";
        }

    }

    public function exportBasicFee(Request $request)
    {
        $basicFees = DB::table('fee_basic_table')->get();
        foreach ($basicFees as $basicFee) {
            $export[] = array(
                '塔型'             => $basicFee->tower_type,
                '系统挂高（米）'        => $basicFee->sys_height,
                '配套类型'           => $basicFee->product_type,
                '是否为新建站'         => $basicFee->is_new_tower,
                '基准价格（元/天）（不含税）' => $basicFee->fee_basic,

            );
        }
        Excel::create('基准服务价格标准', function ($excel) use ($export) {
            $excel->sheet('基准服务价格标准', function ($sheet) use ($export) {
                $sheet->fromArray($export);
            });
        })->export('xls');

    }

    public function exportSiteFee(Request $request)
    {
        $region = $request->get('region');
        if ($region == '湖北省') {
            $siteFees = DB::table('fee_site_std')->get();
        } else {
            $siteFees = DB::table('fee_site_std')->where('region_name', $region)->get();
        }
        foreach ($siteFees as $siteFee) {
            $export[] = array(
                '地市'            => $siteFee->region_name,
                '站址所在地区类型'      => $siteFee->site_district_type,
                '是否RRU拉远'       => $siteFee->is_rru_away,
                '场地费（元/天）（不含税）' => $siteFee->fee_site,

            );
        }

        Excel::create('场地费价格标准', function ($excel) use ($export) {
            $excel->sheet('场地费价格标准', function ($sheet) use ($export) {
                $sheet->fromArray($export);
            });
        })->export('xls');

    }

    public function exportElecImportFee(Request $request)
    {
        $region = $request->get('region');
        if ($region == '湖北省') {
            $elecImportFees = DB::table('fee_import_std')->get();
        } else {
            $elecImportFees = DB::table('fee_import_std')->where('region_name', $region)->get();
        }

        foreach ($elecImportFees as $elecImportFee) {
            $export[] = array(
                '地市'              => $elecImportFee->region_name,
                '引电类型'            => $elecImportFee->elec_introduced_type,
                '电力引入费（元/天）（不含税）' => $elecImportFee->fee_import,

            );
        }

        Excel::create('电力引入费价格标准', function ($excel) use ($export) {
            $excel->sheet('电力引入费价格标准', function ($sheet) use ($export) {
                $sheet->fromArray($export);
            });
        })->export('xls');

    }

    public function exportDiscount(Request $request)
    {
        $feeType   = $request->get('fee_type');
        $discounts = DB::table('share_discount')->get();
        foreach ($discounts as $discount) {
            $export[] = array(
                '是否为新建站'   => $discount->is_new_tower,
                '共享类型'     => $discount->share_type,
                '用户类型'     => $discount->user_type,
                '是否存在新增共享' => $discount->is_newly_added,
                '基准价格折扣'   => $discount->discount_basic,
                '场地费折扣'    => $discount->discount_site,
                '电力引入费折扣'  => $discount->discount_import,

            );
        }

        Excel::create('共享折扣', function ($excel) use ($export) {
            $excel->sheet('共享折扣', function ($sheet) use ($export) {
                $sheet->fromArray($export);
            });
        })->export('xls');

    }

    public function exportGnrRec(Request $request)
    {
        $region    = $request->get('region_export');
        $site_code = $request->get('siteCode_export');
        $gnrRecs   = DB::table('fee_out_gnr')->where('region_name', $region)->where('site_code', $site_code)->get();
        if (!empty($gnrRecs)) {
            foreach ($gnrRecs as $gnrRec) {
                $export[] = array(
                    '地市'           => $gnrRec->region_name,
                    '站址编码'         => $gnrRec->site_code,
                    '提交时间'         => $gnrRec->created_at,
                    '发电起始时间'       => $gnrRec->gnr_start_time,
                    '发电终止时间'       => $gnrRec->gnr_stop_time,
                    '发电时长'         => $gnrRec->gnr_len,
                    '发电费用（元）（不含税）' => $gnrRec->gnr_fee,
                    '发电费用（元）（含税）'  => $gnrRec->gnr_fee_taxed,

                );
            }

            Excel::create('发电信息', function ($excel) use ($export) {
                $excel->sheet('发电信息', function ($sheet) use ($export) {
                    $sheet->fromArray($export);
                });
            })->export('xls');
        } else {
            echo "<script>history.back()</script>";
        }
    }

    public function importSiteInfo(Request $request)
    {
        $filter     = $request->all();
        $region     = $request->input('region', '');
        $file       = $request->file('siteInfoFile');
        $clientName = $file->getClientOriginalName();
        $file_types = explode(".", $clientName);
        $file_type  = $file_types[count($file_types) - 1];
        if (strtolower($file_type) != "xlsx" && strtolower($file_type) != "xls") {
            echo "<script language=javascript>alert('不是Excel文件，请重新上传！');history.back();</script>";
        } else {
            $savePath  = 'storage/app';
            $str       = date('Ymdhis');
            $file_name = $str . "." . $file_type;
            $path      = $file->move($savePath, $file_name);
            $filePath  = "public/storage/app/";
//        $reader->setOutputEncoding('UTF-8');
            Excel::load($filePath . $file_name, function ($reader) {
//            获取excel的第1张表
                $reader = $reader->getSheet(0);
//            获取表中的数据
                $results    = $reader->toArray();
                $siteInfoDB = new SiteInfo();
                $area_level = Auth::user()->area_level;
                $siteInfoDB->addInfoSiteByArray($results, $area_level);

            });
            return redirect('backend/siteInfo')
            ->with('filter', $filter)
            ->with('flag', 'add');
        }
    }

    public function bulkUpdateSiteInfo(Request $request)
    {
        $filter = $request->all();
        $region = $request->input('region', '');
        $file   = $request->file('siteInfoToUpdateFile');
        if ($region != "请选择...") {
            $clientName = $file->getClientOriginalName();
            $file_types = explode(".", $clientName);
            $file_type  = $file_types[count($file_types) - 1];
            if (strtolower($file_type) != "xlsx" && strtolower($file_type) != "xls") {
                echo "<script language=javascript>alert('不是Excel文件，请重新上传！');history.back();</script>";
            } else {
                $savePath  = 'storage/app';
                $str       = date('Ymdhis');
                $file_name = $str . "." . $file_type;
                $path      = $file->move($savePath, $file_name);
                $filePath  = "public\storage\app\\";
//        $reader->setOutputEncoding('UTF-8');
                Excel::load($filePath . $file_name, function ($reader) {
//            获取excel的第1张表
                    $reader = $reader->getSheet(0);
//            获取表中的数据
                    $results    = $reader->toArray();
                    $area_level = Auth::user()->area_level;
                    $siteInfoDB = new SiteInfo();
                    $siteInfoDB->updateInfoSiteByArray($results, $area_level);

                });
                $siteinfoDB = new SiteInfo();
                $infoSites  = $siteinfoDB->searchInfoSite($region);
                return view('backend/siteInfo/index')->with('infoSites', $infoSites)
                ->with('filter', $filter);
            }

        } else {

            $clientName = $file->getClientOriginalName();
            $file_types = explode(".", $clientName);
            $file_type  = $file_types[count($file_types) - 1];
            if (strtolower($file_type) != "xlsx" && strtolower($file_type) != "xls") {
                echo "<script language=javascript>alert('不是Excel文件，请重新上传！');history.back();</script>";
            } else {
                $savePath  = 'storage/app';
                $str       = date('Ymdhis');
                $file_name = $str . "." . $file_type;
                $path      = $file->move($savePath, $file_name);
                $filePath  = "public\storage\app\\";
//        $reader->setOutputEncoding('UTF-8');
                Excel::load($filePath . $file_name, function ($reader) {
//            获取excel的第1张表
                    $reader = $reader->getSheet(0);
//            获取表中的数据
                    $results    = $reader->toArray();
                    $siteInfoDB = new SiteInfo();
                    $siteInfoDB->addInfoSiteByArray($results);
                });
                return view('backend/siteInfo/index')->with('filter', $filter);
            }

        }
    }

    public function importGnrRec(Request $request)
    {
        $file       = $request->file('gnrRecFile');
        $clientName = $file->getClientOriginalName();
        $file_types = explode(".", $clientName);
        $file_type  = $file_types[count($file_types) - 1];
        if (strtolower($file_type) != "xlsx" && strtolower($file_type) != "xls") {
            echo "<script language=javascript>alert('不是Excel文件，请重新上传！');history.back();</script>";
        } else {
            $savePath  = 'storage/app';
            $str       = date('Ymdhis');
            $file_name = $str . "." . $file_type;
            $path      = $file->move($savePath, $file_name);
            $filePath  = "public\storage\app\\";
//        $reader->setOutputEncoding('UTF-8');
            Excel::load($filePath . $file_name, function ($reader) {
//            获取excel的第1张表
                $reader = $reader->getSheet(0);
//            获取表中的数据
                $results  = $reader->toArray();
                $gnrRecDB = new GnrRec();
                $gnrRecDB->addGnrRecByArray($results);

            });
            $filter   = $request->all();
            $siteCode = $request->get('siteCode');

            $gnrRecDB                    = new GnrRec();
            $siteInfos                   = DB::table('site_info')->where('site_code', $siteCode)->where('is_valid', '是')->get();
            $gnrRecs                     = $gnrRecDB->searchGnr($siteCode);
            $gnr_total_len_minute        = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_len_minute');
            $gnr_total_len_hour          = floor($gnr_total_len_minute / 60);
            $gnr_total_len_minutes       = $gnr_total_len_minute % 60;
            $gnr_total_len               = $gnr_total_len_hour . ':' . $gnr_total_len_minutes;
            $gnr_num                     = count($gnrRecs);
            $gnr_total_fee               = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_fee');
            $last_gnr_time               = DB::table('fee_out_gnr')->where('site_code', $siteCode)->max('gnr_stop_time');
            $siteInfos[0]->last_gnr_time = $last_gnr_time;
            $siteInfos[0]->gnr_total_len = $gnr_total_len;
            $siteInfos[0]->gnr_num       = $gnr_num;
            $siteInfos[0]->gnr_total_fee = $gnr_total_fee;
            return redirect('backend/gnrRec/indexGnr')->with('siteInfos', $siteInfos)
            ->with('gnrRecs', $gnrRecs)
            ->with('filter', $filter)
            ->with('flag', 'import');
        }

    }

//     public function transIronTowerSiteInfo(Request $request)
//     {

//         include '/Applications/XAMPP/xamppfiles/htdocs/IronTower/public/common/PHPExcel-1.8/Classes/PHPExcel.php';
//         $filter     = $request->all();
//         $region     = $request->input('region', '');
//         $file       = $request->file('ironTowerSiteInfoFile');
//         $clientName = $file->getClientOriginalName();
//         $file_types = explode(".", $clientName);
//         $file_type  = $file_types[count($file_types) - 1];
//         if (strtolower($file_type) != "xlsx" && strtolower($file_type) != "xls") {
//             echo "<script language=javascript>alert('不是Excel文件，请重新上传！');history.back();</script>";
//         } else {
//             $savePath  = 'storage/app';
//             $str       = date('Ymdhis');
//             $file_name = $str . "." . $file_type;
//             $path      = $file->move($savePath, $file_name);
//             $filePath  = "public/storage/app/";
// //        $reader->setOutputEncoding('UTF-8');
//             Excel::load($filePath . $file_name, function ($reader) {
// //            获取excel的第1张表
//                 $reader = $reader->getSheet(0);
// //            获取表中的数据
//                 $results    = $reader->toArray();
//                 $siteInfoDB = new SiteInfo();
//                 $area_level = Auth::user()->area_level;
//                 $infoSites  = $siteInfoDB->transIronTowerSiteInfo($results, $area_level);
//                 foreach ($infoSites as $infoSite) {
//                     $export[] = array(
// //                        '产品业务确认单编号' => $infoSite[0],
//                         //                        '站址编码' => $infoSite[1],
//                         //                        '站址名称' => $infoSite[2],
//                         //                        'C网网管编号' => $infoSite[3],
//                         //                        'L网网管编号' => $infoSite[4],
//                         //                        '需求确认单编号' => $infoSite[5],
//                         //                        '地市' => $infoSite[6],
//                         //                        '产品配套类型' => $infoSite[7],
//                         //                        '服务起始日期' => $infoSite[8],
//                         //                        '是否为新建站' => $infoSite[9],
//                         //                        '铁塔类型' => $infoSite[10],
//                         //                        '系统数量' => $infoSite[11],
//                         //                        '系统1挂高' => $infoSite[12],
//                         //                        '系统2挂高' => $infoSite[13],
//                         //                        '系统3挂高' => $infoSite[14],
//                         //                        '站址位置' => $infoSite[15],
//                         //                        '是否为竞合站点' => $infoSite[16],
//                         //                        '机房共享用户数' => $infoSite[17],
//                         //                        '机房共享运营商1的起租日期' => $infoSite[18],
//                         //                        '机房共享运营商2的起租日期' => $infoSite[19],
//                         //                        '铁塔共享用户数' => $infoSite[20],
//                         //                        '铁塔共享运营商1的起租日期' => $infoSite[21],
//                         //                        '铁塔共享运营商2的起租日期' => $infoSite[22],
//                         //                        '配套共享用户数' => $infoSite[23],
//                         //                        '配套共享运营商1的起租日期' => $infoSite[24],
//                         //                        '配套共享运营商2的起租日期' => $infoSite[25],
//                         //                        '维护费共享用户数' => $infoSite[26],
//                         //                        '维护费共享运营商1的起租日期' => $infoSite[27],
//                         //                        '维护费共享运营商2的起租日期' => $infoSite[28],
//                         //                        '场地费共享用户数' => $infoSite[29],
//                         //                        '场地费共享运营商1的起租日期' => $infoSite[30],
//                         //                        '场地费共享运营商2的起租日期' => $infoSite[31],
//                         //                        '电力引入费共享用户数' => $infoSite[32],
//                         //                        '电力引入费共享运营商1的起租日期' => $infoSite[33],
//                         //                        '电力引入费共享运营商2的起租日期' => $infoSite[34],
//                         //                        '覆盖场景' => $infoSite[35],
//                         //                        'RRU是否拉远' => $infoSite[36],
//                         //                        '用户类型' => $infoSite[37],
//                         //                        '引电类型' => $infoSite[38],
//                         //                        'WLAN费用' => $infoSite[39],
//                         //                        '微波费用' => $infoSite[40],
//                         //                        '超过10%高等级服务站址额外维护服务费' => $infoSite[41],
//                         //                        '蓄电池额外保障费' => $infoSite[42],
//                         //                        'bbu安装在铁塔机房费' => $infoSite[43],
//                         //                        '场地费' => $infoSite[44],
//                         0  => $infoSite[0],
//                         1  => $infoSite[1],
//                         2  => $infoSite[2],
//                         3  => $infoSite[3],
//                         4  => $infoSite[4],
//                         5  => $infoSite[5],
//                         6  => $infoSite[6],
//                         7  => $infoSite[7],
//                         8  => $infoSite[8],
//                         9  => $infoSite[9],
//                         10 => $infoSite[10],
//                         11 => $infoSite[11],
//                         12 => $infoSite[12],
//                         13 => $infoSite[13],
//                         14 => $infoSite[14],
//                         15 => $infoSite[15],
//                         16 => $infoSite[16],
//                         17 => $infoSite[17],
//                         18 => $infoSite[18],
//                         19 => $infoSite[19],
//                         20 => $infoSite[20],
//                         21 => $infoSite[21],
//                         22 => $infoSite[22],
//                         23 => $infoSite[23],
//                         24 => $infoSite[24],
//                         25 => $infoSite[25],
//                         26 => $infoSite[26],
//                         27 => $infoSite[27],
//                         28 => $infoSite[28],
//                         29 => $infoSite[29],
//                         30 => $infoSite[30],
//                         31 => $infoSite[31],
//                         32 => $infoSite[32],
//                         33 => $infoSite[33],
//                         34 => $infoSite[34],
//                         35 => $infoSite[35],
//                         36 => $infoSite[36],
//                         37 => $infoSite[37],
//                         38 => $infoSite[38],
//                         39 => $infoSite[39],
//                         40 => $infoSite[40],
//                         41 => $infoSite[41],
//                         42 => $infoSite[42],
//                         43 => $infoSite[43],
//                         44 => $infoSite[44],
//                         45 => $infoSite[45],
//                         46 => $infoSite[46],

//                     );
// }
// $excel = new PHPExcel();
// $excel->getProperties()->setCreator("yy")
// ->setLastModifiedBy("yy")
// ->setTitle("站址属性")
// ->setSubject("站址属性")
// ->setDescription("站址属性")
// ->setKeywords("excel")
// ->setCategory("result file");
// $letter = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T',
//     'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN',
//     'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU');
// $tableHeader = array('产品业务确认单编号', '站址编码', '站址名称', 'C网网管编号', 'L网网管编号', '需求确认单编号', '地市', '产品配套类型',
//     '服务起始日期', '是否为新建站', '铁塔类型', '系统数量1', '系统1挂高', '系统数量2', '系统2挂高', '系统数量1', '系统3挂高', '站址位置', '是否为竞合站点', '机房共享用户数',
//     '机房共享运营商1的起租日期', '机房共享运营商2的起租日期', '铁塔共享用户数', '铁塔共享运营商1的起租日期', '铁塔共享运营商2的起租日期',
//     '配套共享用户数', '配套共享运营商1的起租日期', '配套共享运营商2的起租日期', '维护费共享用户数', '维护费共享运营商1的起租日期',
//     '维护费共享运营商2的起租日期', '场地费共享用户数', '场地费共享运营商1的起租日期', '场地费共享运营商2的起租日期', '电力引入费共享用户数',
//     '电力引入费共享运营商1的起租日期', '电力引入费共享运营商2的起租日期', '覆盖场景', 'RRU是否拉远', '用户类型', '引电类型', 'WLAN费用',
//     '微波费用', '超过10%高等级服务站址额外维护服务费', '蓄电池额外保障费', 'bbu安装在铁塔机房费', '场地费');
// for ($i = 0; $i < count($tableHeader); $i++) {
//     $excel->getActiveSheet()->setCellValue("$letter[$i]1", "$tableHeader[$i]");
// }
// //                foreach ($export)
// for ($i = 2; $i <= count($export) + 1; $i++) {
//     $j = 0;
//     foreach ($export[$i - 2] as $key => $value) {
//         $excel->getActiveSheet()->setCellValueExplicit("$letter[$j]$i", $value, \PHPExcel_Cell_DataType::TYPE_STRING);
//         $j++;
//     }
// }
// $write = new \PHPExcel_Writer_Excel5($excel);
// header("Pragma: public");
// header("Expires: 0");
// header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
// header("Content-Type:application/force-download");
// header("Content-Type:application/vnd.ms-execl");
// header("Content-Type:application/octet-stream");
// header("Content-Type:application/download");;
// header('Content-Disposition:attachment;filename="站址属性.xls"');
// header("Content-Transfer-Encoding:binary");
// $write->save('php://output');
// //                Excel::create('站址属性信息', function ($excel) use ($export) {
//                 //                    $excel->sheet('站址属性信息', function ($sheet) use ($export) {
//                 //                        $sheet->fromArray($export);
//                 //                    });
//                 //                })->export('xlsx');
// });
// }

// }

    public function importBillDetail(Request $request)
    {
        $filter     = $request->all();
        $region     = $request->input('region', '');
        $file       = $request->file('billDetailFile');
        $clientName = $file->getClientOriginalName();
        $file_types = explode(".", $clientName);
        $file_type  = $file_types[count($file_types) - 1];
        if (strtolower($file_type) != "xlsx" && strtolower($file_type) != "xls") {
            echo "<script language=javascript>alert('不是Excel文件，请重新上传！');history.back();</script>";
        } else {
            $savePath  = 'storage/app/billDetail';
            $str       = date('Ymdhis');
            $file_name = $str . "." . $file_type;
            $path      = $file->move($savePath, $file_name);
            $filePath  = "public/storage/app/billDetail/";
//        $reader->setOutputEncoding('UTF-8');
            Excel::load($filePath . $file_name, function ($reader) {
//            获取excel的第1张表
                $reader = $reader->getSheet(0);
//            获取表中的数据
                $results    = $reader->toArray();
                $irontowerBillDetailDB = new IronTowerBillDetail();
                for ($i = 1; $i < count($results); $i++){
                    $irontowerBillDetailDB->store($results[$i]);
                }
                $year = substr($results[1][0],0,4);
                $month = substr($results[1][0],4,2);
                $siteInfos = IronTowerBillDetail::where('month',$year.'-'.$month)
                ->get();
                foreach ($siteInfos as $siteInfo) {
                    if (substr($siteInfo->req_code,0,2) == '11') {
                        IronTowerBillDetail::where('id',$siteInfo->id)
                        ->update(['is_new_tower' =>0]);
                        $old_to_rm = IronTowerBillDetail::where('month', $year.'-'.$month)
                        ->where('req_code','like','10'.'%')
                        ->where('site_code', $siteInfo->site_code)
                        ->update(['is_new_tower' => 2]);
                        $old_to_rm = IronTowerBillDetail::where('month', $year.'-'.$month)
                        ->where('req_code','like','12'.'%')
                        ->where('site_code', $siteInfo->site_code)
                        ->update(['is_new_tower' => 2]);
                    }
                }
            });


        }


    }
}
