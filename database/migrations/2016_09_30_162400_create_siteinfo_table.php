<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteinfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_info', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('site_code')->index();
            $table->string('region_name');
            $table->string('city_name');
            $table->string('product_type');
            $table->string('tower_type');
            $table->integer('sys_num');
            $table->integer('share_num');
            $table->string('is_tower_property');
            $table->string('site_district_type');
            $table->string('is_rru_away');
            $table->string('tower_built_type');
            $table->string('elec_introduced_type');
        });

//        Schema::create('area_info', function(Blueprint $table)
//        {
//            $table->increments('seq');
//            $table->integer('province_id');
//            $table->string('province_name');
//        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('site_info');
//        Schema::drop('area_info');
    }
}
