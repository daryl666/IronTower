<?php

namespace App\Models;

class Admin{
    // 判断是否有某个权限
    public function hasPermission($permits,$adminPermission)
    {
        $tag = 1;
        foreach ($permits as $permit){
            if($adminPermission[$permit] == 0){
                $tag = null;
            }
        }
        return $tag;
    }
}
