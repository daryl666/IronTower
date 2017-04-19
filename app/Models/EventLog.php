<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;


class EventLog extends Model
{
    function addEvent($regionName, $regionID = '', $operator, $operation, $tableName, $recordID = null)
    {
        DB::table('sys_log')
            ->insert([
                'region_id' => transRegion($regionName),
                'region_name' => $regionName,
                'operation' => $operation,
                'operator' => $operator,
                'table_name' => $tableName,
                'record_id' => $recordID
            ]);
    }
}
