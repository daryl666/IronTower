<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','password','phone_number','site_add','site_view_basic', 'site_view_advance', 'site_modify','site_batch_import', 'site_batch_export','is_verified','site_delete','area_level','bill_view','bill_out','gnr_manage','site_check_manage','site_shield_manage','os_reason_manage'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
