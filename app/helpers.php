<?php
/**
 * Created by PhpStorm.
 * User:
 */

/*金额按元显示*/
if (!function_exists('formatNumber')) {

    function formatNumber($number)
    {
        if ($number == 0)
            return 0.00;
        return sprintf("%.2f", $number);
    }

}
/*金额按万元显示*/
if (!function_exists('formatNumber_wan')) {

    function formatNumber_wan($number)
    {
        if ($number == 0)
            return 0.0000;
        return sprintf("%.6f", $number / 10000);
    }

}

/*商品类型字段定义*/
if (!function_exists('transFeeOutStatus')) {

    function transFeeOutStatus($post_type)
    {
        $map = [
            0 => '未出账',
            1 => '已出账',
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';

    }

}

/*地市字段定义*/
if (!function_exists('transRegion')) {

    function transRegion($post_type)
    {
        $map = [
            420000 => '湖北省',
            420100 => '武汉',
            420200 => '黄石',
            420300 => '十堰',
            420500 => '宜昌',
            420600 => '襄阳',
            420700 => '鄂州',
            420800 => '荆门',
            420900 => '孝感',
            421000 => '荆州',
            421100 => '黄冈',
            421200 => '咸宁',
            421300 => '随州',
            422800 => '恩施',
            429000 => '仙桃',
            429100 => '潜江',
            429200 => '天门',
            429300 => '林区',
            '湖北省' => 420000,
            '武汉' => 420100,
            '武汉市' => 420100,
            '黄石' => 420200,
            '黄石市' => 420200,
            '十堰' => 420300,
            '十堰市' => 420300,
            '宜昌' => 420500,
            '宜昌市' => 420500,
            '襄阳' => 420600,
            '襄阳市' => 420600,
            '鄂州' => 420700,
            '鄂州市' => 420700,
            '荆门' => 420800,
            '荆门市' => 420800,
            '孝感' => 420900,
            '孝感市' => 420900,
            '荆州' => 421000,
            '荆州市' => 421000,
            '黄冈' => 421100,
            '黄冈市' => 421100,
            '咸宁' => 421200,
            '咸宁市' => 421200,
            '随州' => 421300,
            '随州市' => 421300,
            '恩施' => 422800,
            '恩施土家族苗族自治州' => 422800,
            '仙桃' => 429000,
            '仙桃市' => 429000,
            '潜江' => 429100,
            '潜江市' => 429100,
            '天门' => 429200,
            '天门市' => 429200,
            '林区' => 429300,
            '神农架林区' => 429300,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';

    }

}

/*产品配套类型字段定义*/
if (!function_exists('transProductType')) {

    function transProductType($post_type)
    {
        $map = [
            1 => '铁塔+自有机房+配套',
            2 => '铁塔+租赁机房+配套',
            3 => '铁塔+一体化机柜+配套',
            4 => '铁塔+RRU拉远+配套',
            5 => '铁塔(无机房及配套)',
            '铁塔+自有机房+配套' => 1,
            '铁塔+租赁机房+配套' => 2,
            '铁塔+一体化机柜+配套' => 3,
            '铁塔+RRU拉远+配套' => 4,
            '铁塔(无机房及配套)' => 5,
            '铁塔(无机房及配套)' => 5,
            'RRU拉远' => 4,
            '无机房' => 5,
            '一体化机房' => 3,
            '一体化机柜' => 3,
            '自建彩钢板机房' => 1,
            '自建砖混机房' => 1,
            '其他机房' => 1,
            '租用机房' => 2,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';

    }

}

/*铁塔类型字段定义*/
if (!function_exists('transTowerType')) {

    function transTowerType($post_type)
    {
        $map = [
            1 => '普通地面塔',
            2 => '景观塔',
            3 => '简易塔',
            4 => '普通楼面塔',
            5 => '楼面抱杆',
            '普通地面塔' => 1,
            '景观塔' => 2,
            '简易塔' => 3,
            '普通楼面塔' => 4,
            '楼面抱杆' => 5,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';

    }

}

/*系统挂高字段定义*/
if (!function_exists('transSysHeight')) {

    function transSysHeight($post_type)
    {
        $map = [
            1 => 'H<20',
            2 => 'H<30',
            3 => '20<=H<25',
            4 => '25<=H<30',
            5 => '30<=H<35',
            6 => '35<=H<40',
            7 => '40<=H<45',
            8 => '45<=H<50',
            9 => '任意高度',
            'H<20' => 1,
            'H≤20' => 1,
            'H<30' => 2,
            'H≤30' => 2,
            '20<=H<25' => 3,
            '20≤H<25' => 3,
            '20≤H≤25' => 3,
            '25<=H<30' => 4,
            '25≤H<30' => 4,
            '25≤H≤30' => 4,
            '30<=H<35' => 5,
            '30≤H<35' => 5,
            '30≤H≤35' => 5,
            '35<=H<40' => 6,
            '35≤H<40' => 6,
            '35≤H≤40' => 6,
            '40<=H<45' => 7,
            '40≤H<45' => 7,
            '40≤H≤45' => 7,
            '45<=H<50' => 8,
            '45≤H<50' => 8,
            '45≤H≤50' => 8,
            '任意高度' => 9,
            '-' => 9,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';

    }

}

/*是否竞合站点字段定义*/
if (!function_exists('transIsCoOpetition')) {

    function transIsCoOpetition($post_type)
    {
        $map = [
            0 => '否',
            1 => '是',
            '否' => 0,
            '是' => 1,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';

    }

}

/*是否存在新增共享字段定义*/
if (!function_exists('transIsNewlyAdded')) {

    function transIsNewlyAdded($post_type)
    {
        $map = [
            0 => '否',
            1 => '是',
            '否' => 0,
            '是' => 1,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';

    }

}

/*共享类型字段定义*/
if (!function_exists('transShareType')) {

    function transShareType($post_type)
    {
        $map = [
            1 => '电信独享',
            1 => '电信独享',
            2 => '两家共享',
            3 => '三家共享',
            0 => '未知',
            '电信独享' => 1,
            '两家共享' => 2,
            '三家共享' => 3,
            '' => 0,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';

    }

}

/*站址所在地区类型字段定义*/
if (!function_exists('transSiteDistType')) {

    function transSiteDistType($post_type)
    {
        $map = [
            1 => '市区',
            2 => '城镇',
            3 => '农村',
            999 => '未知',
            '市区' => 1,
            '城镇' => 2,
            '农村' => 3,
            '' => 999,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';

    }

}

/*是否RRU拉远字段定义*/
if (!function_exists('transIsRRUAway')) {

    function transIsRRUAway($post_type)
    {
        $map = [
            0 => '否',
            1 => '是',
            '否' => 0,
            '是' => 1,
            'RRU拉远' => 1,
            '无机房' => 0,
            '一体化机房' => 0,
            '一体化机柜' => 0,
            '自建彩钢板机房' => 0,
            '自建砖混机房' => 0,
            '其他机房' => 0,
            '租用机房' => 0,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';

    }

}

/*用户类型字段定义*/
if (!function_exists('transUserType')) {

    function transUserType($post_type)
    {
        $map = [
            1 => '锚定用户',
            2 => '其他用户',
            3 => '原产权',
            4 => '既有共享',
            5 => '新增共享',
            6 => '其他',
            '锚定用户' => 1,
            '其他用户' => 2,
            '原产权' => 3,
            '既有共享' => 4,
            '新增共享' => 5,
            '其他' => 6,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';

    }

}

/*是否为新建站字段定义*/
if (!function_exists('transIsNewTower')) {

    function transIsNewTower($post_type)
    {
        $map = [
            0 => '否',
            1 => '是',
            '否' => 0,
            '是' => 1,
            '新建' => 1,
            '存量改造' => 0,
            '既有共享' => 0,
            '原产权方' => 0,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';

    }

}

/*引电类型字段定义*/
if (!function_exists('transElecType')) {

    function transElecType($post_type)
    {
        $map = [
            0 => '220V',
            1 => '380V',
            999 => '未知',
            '220V' => 0,
            '380V' => 1,
            '未知' => 999,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';

    }

}

/*覆盖地形字段定义*/
if (!function_exists('transLandForm')) {

    function transLandForm($post_type)
    {
        $map = [
            0 => '平原',
            1 => '山区',
            '平原' => 0,
            '山区' => 1,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';

    }

}

/*基站等级字段定义*/
if (!function_exists('transStationLevel')) {

    function transStationLevel($post_type)
    {
        $map = [
            1 => 'A',
            2 => 'B',
            3 => 'C',
            4 => 'D',
            'A' => 1,
            'B' => 2,
            'C' => 3,
            'D' => 4,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';

    }

}

/*退服原因字段定义*/
if (!function_exists('transOsReason')) {

    function transOsReason($post_type)
    {
        $map = [
            1 => '停电',
            2 => '电源设别',
            3 => '传输线路',
            4 => '传输设备',
            5 => '物业',
            6 => '核心网',
            7 => '高温',
            8 => '其他',
            9 => '局端',
            10 => '主设备',
            '停电' => 1,
            '电源设备' => 2,
            '传输线路' => 3,
            '传输设备' => 4,
            '物业' => 5,
            '核心网' => 6,
            '高温' => 7,
            '其他' => 8,
            '局端' => 9,
            '主设备' => 10,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';

    }

}

/*责任单位字段定义*/
if (!function_exists('transRespUnit')) {

    function transRespUnit($post_type)
    {
        $map = [
            1 => '铁塔',
            2 => '电信',
            3 => '移动',
            4 => '联通',
            '铁塔' => 1,
            '电信' => 2,
            '移动' => 3,
            '联通' => 4,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';

    }

}

/*屏蔽申请原因字段定义*/
if (!function_exists('transShieldReason')) {

    function transShieldReason($post_type)
    {
        $map = [
            1 => '故障',
            2 => '拆迁',
            3 => '拆迁还建',
            '故障' => 1,
            '拆迁' => 2,
            '拆迁还建' => 3,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';

    }

}

/*拆迁原因字段定义*/
if (!function_exists('transDemReason')) {

    function transDemReason($post_type)
    {
        $map = [
            1 => '物业纠纷',
            2 => '市政建设',
            3 => '自然灾害',
            '物业纠纷' => 1,
            '市政建设' => 2,
            '自然灾害' => 3,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';

    }

}

/*上站结果字段定义*/
if (!function_exists('transSiteCheckResult')) {

    function transSiteCheckResult($post_type)
    {
        $map = [
            0 => '失败',
            1 => '成功',
            '失败' => 0,
            '成功' => 1,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';

    }

}

/*发电发起方字段定义*/
if (!function_exists('transGnrRaiseSide')) {

    function transGnrRaiseSide($post_type)
    {
        $map = [
            1 => '铁塔',
            2 => '电信',
            '铁塔' => 1,
            '电信' => 2,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';

    }

}

/*发电结果字段定义*/
if (!function_exists('transGnrResult')) {

    function transGnrResult($post_type)
    {
        $map = [
            2 => '失败',
            1 => '成功',
            '失败' => 2,
            '成功' => 1,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';

    }

}

if (!function_exists('transShareDisc')) {

    function transShareDisc($disc1, $disc2)
    {
        if (!empty($disc2) && $disc2 != '0.00') {
            return $disc2;
        } elseif ((empty($disc2) || $disc2 == '0.00') && !empty($disc1) && $disc1 != '0.00') {
            return $disc1;
        } elseif ((empty($disc2) && empty($disc1)) || ($disc1 == '0.00' && $disc2 == '0.00')) {
            return 1;
        }
    }

}

if (!function_exists('object2array')) {
    function object2array(&$object)
    {
        $object = json_decode(json_encode($object), true);
        return $object;
    }
}

if (!function_exists('compareTheSiteAttributes')) {
    function compareTheSiteAttributes($excepSiteInfos = '', $origSiteInfos = '', $attributeName = '', $attributeValue = '', $id, $importSiteExceptionId = '')
    {
        if (empty($excepSiteInfos)) {
            foreach ($origSiteInfos as $origSiteInfo) {
                if ($origSiteInfo->import_site_exception_id === $id) {
                    if ($origSiteInfo->$attributeName === $attributeValue) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        }
        if (empty($origSiteInfos)) {
            foreach ($excepSiteInfos as $excepSiteInfo) {
                if ($excepSiteInfo->site_info_id === $id && $excepSiteInfo->id === $importSiteExceptionId) {
                    if ($excepSiteInfo->$attributeName === $attributeValue) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        }
    }
}

if (!function_exists('compareBills')) {
    function compareBills($costIronTower, $costTelecom)
    {
        return $costIronTower === $costTelecom;
    }
}

if (!function_exists('compareOrderDetail')) {
    function compareOrderDetail($orderIronTower, $orderTelecom)
    {
        return $orderIronTower === $orderTelecom;

    }
}

if (!function_exists('transGnrStatus')) {
    function transGnrStatus($post_type)
    {
        $map = [
            1 => '发电前退服',
            2 => '发电过程中退服',
            3 => '发结束后仍然退服',
            '发电前退服' => 1,
            '发电过程中退服' => 2,
            '发结束后仍然退服' => 3,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';
    }
}


if (!function_exists('transRentSiteType')) {
    function transRentSiteType($post_type)
    {
        $map = [
            1 => '租用站址',
            2 => '自有站址',
            3 => '第三方站址',
            '租用站址' => 1,
            '自有站址' => 2,
            '第三方站址' => 3,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';
    }
}

if (!function_exists('transSiteProperty')) {
    function transSiteProperty($post_type)
    {
        $map = [
            1 => '存量原产权',
            2 => '存量既有共享',
            3 => '存量自改',
            4 => '存量共享改造',
            5 => '新建铁塔',
            '存量原产权' => 1,
            '存量既有共享' => 2,
            '存量自改' => 3,
            '存量共享改造' => 4,
            '新建铁塔' => 5,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';
    }
}

if (!function_exists('transSiteNet')) {
    function transSiteNet($post_type)
    {
        $map = [
            1 => '村通',
            2 => 'C村',
            3 => 'CDMA',
            4 => 'C村L',
            5 => 'CL',
            '村通' => 1,
            'C村' => 2,
            'CDMA' => 3,
            'C村L' => 4,
            'CL' => 5,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';
    }
}

if (!function_exists('transTowerOriProperty')) {
    function transTowerOriProperty($post_type)
    {
        $map = [
            1 => '铁塔',
            2 => '电信',
            3 => '移动',
            4 => '联通',
            5 => '广电',
            6 => '第三方',
            '铁塔' => 1,
            '电信' => 2,
            '移动' => 3,
            '联通' => 4,
            '广电' => 5,
            '第三方' => 6,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';
    }
}

if (!function_exists('transPowerSupplyMode')) {
    function transPowerSupplyMode($post_type)
    {
        $map = [
            1 => '直供电',
            2 => '转供电',
            '直供电' => 1,
            '转供电' => 2,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';
    }
}

if (!function_exists('transBBULocation')) {
    function transBBULocation($post_type)
    {
        $map = [
            1 => '铁塔机房',
            2 => '自有机房',
            3 => '第三方机房',
            '铁塔机房' => 1,
            '自有机房' => 2,
            '第三方机房' => 3,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';
    }
}

if (!function_exists('transRRULocation')) {
    function transRRULocation($post_type)
    {
        $map = [
            1 => '机房',
            2 => '塔上',
            '机房' => 1,
            '塔上' => 2,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';
    }
}

if (!function_exists('transSiteLevel')) {
    function transSiteLevel($post_type)
    {
        $map = [
            1 => '高等级',
            2 => '标准等级',
            '高等级' => 1,
            '标准等级' => 2,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';
    }
}

if (!function_exists('transIsMountainSite')) {
    function transIsMountainSite($post_type)
    {
        $map = [
            1 => '非高山站',
            2 => '高山站',
            '非高山站' => 1,
            '高山站' => 2,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';
    }
}

if (!function_exists('transSPDLevel')) {
    function transSPDLevel($post_type)
    {
        $map = [
            1 => '正常',
            2 => '故障',
            3 => '无',
            '正常' => 1,
            '故障' => 2,
            '无' => 3,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';
    }
}

if (!function_exists('transIsBusinessEarth')) {
    function transIsBusinessEarth($post_type)
    {
        $map = [
            1 => '未接地',
            2 => '正常',
            '未接地' => 1,
            '正常' => 2,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';
    }
}

if (!function_exists('transEarthBusbarWire')) {
    function transEarthBusbarWire($post_type)
    {
        $map = [
            1 => '正常',
            2 => '被盗',
            3 => '未接地',
            '正常' => 1,
            '被盗' => 2,
            '未接地' => 3,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';
    }
}

if (!function_exists('transSPDEarthStatus')) {
    function transSPDEarthStatus($post_type)
    {
        $map = [
            1 => 'SPD正常',
            2 => 'SPD故障',
            3 => '接地线被盗',
            4 => '设备未接地',
            'SPD正常' => 1,
            'SPD故障' => 2,
            '接地线被盗' => 3,
            '设备未接地' => 4,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';
    }
}

if (!function_exists('transPowerCabinetCapacity')) {
    function transPowerCabinetCapacity($post_type)
    {
        $map = [
            1 => '正常',
            2 => '故障',
            3 => '容量不足',
            '正常' => 1,
            '故障' => 2,
            '容量不足' => 3,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';
    }
}

if (!function_exists('transBatteryVolume')) {
    function transBatteryVolume($post_type)
    {
        $map = [
            1 => '300AH',
            2 => '500AH',
            3 => '1000AH',
            '300AH' => 1,
            '500AH' => 2,
            '1000AH' => 3,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';
    }
}

if (!function_exists('transBatteryNum')) {
    function transBatteryNum($post_type)
    {
        $map = [
            1 => '1',
            2 => '2',
            '1' => 1,
            '2' => 2,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';
    }
}

if (!function_exists('transBatteryCapacity')) {
    function transBatteryCapacity($post_type)
    {
        $map = [
            1 => '秒退',
            2 => '1小时',
            3 => '2小时',
            3 => '3小时',
            3 => '大于3小时',
            '秒退' => 1,
            '1小时' => 2,
            '2小时' => 3,
            '3小时' => 3,
            '大于3小时' => 3,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';
    }
}

if (!function_exists('transEnvirEquip')) {
    function transEnvirEquip($post_type)
    {
        $map = [
            1 => '空调',
            2 => '风机',
            3 => '无',
            '空调' => 1,
            '风机' => 2,
            '无' => 3,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';
    }
}

if (!function_exists('transEnvirEquipStatus')) {
    function transEnvirEquipStatus($post_type)
    {
        $map = [
            1 => '故障',
            2 => '正常',
            '故障' => 1,
            '正常' => 2,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';
    }
}

if (!function_exists('transTowerDEStatus')) {
    function transTowerDEStatus($post_type)
    {
        $map = [
            1 => '故障',
            2 => '正常',
            '鼓掌' => 1,
            '正常' => 2,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';
    }
}

if (!function_exists('transWhetherOrNot')) {
    function transWhetherOrNot($post_type)
    {
        $map = [
            0 => '否',
            1 => '是',
            '否' => 0,
            '是' => 1,
        ];

        if ($post_type === 'all') {
            return $map;
        }


        if (isset($map[$post_type])) {
            return $map[$post_type];
        }

        return '';
    }
}


