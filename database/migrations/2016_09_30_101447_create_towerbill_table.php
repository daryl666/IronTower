<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTowerbillTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // 出账总表，按区域划分
        Schema::create('fee_out', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('start_day');
            $table->string('end_day');
            $table->integer('region_id');
            $table->string('region_name');
            $table->double('fee_gnr',10,4)->default('0');
            $table->double('fee_site',10,4)->default('0');
            $table->integer('is_out')->default('0');
            $table->integer('operator');
            $table->timestamps();
        });


        // 电费
        Schema::create('fee_out_elec', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('out_id')->default('0')->index();
            $table->string('site_code')->index();
            $table->datetime('start_time');
            $table->datetime('stop_time');
            // 用电度数，千瓦时
            $table->double('elec_amount',10,4)->default('0');
            // 用电单价，元/千瓦时
            $table->double('elec_price',10,4)->default('0');
            // 电费
            $table->double('elec_fee',10,4)->default('0');
            $table->integer('operator');
            $table->timestamps();
        });

        // 发电费
        Schema::create('fee_out_gnr', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('out_id')->default('0')->index();
            $table->string('site_code')->index();
            $table->datetime('gnr_start_time');
            $table->datetime('gnr_stop_time');
            // 实际发电时长，单位分钟
            $table->integer('gnr_len')->default('0');
            // 计费发电时长，如1.5h，按5h计算，单位h
            $table->integer('gnr_compute_len')->default('0');
            // 发电费
            $table->double('gnr_fee',10,4)->default('0');
            // 发电费含税
            $table->double('gnr_fee_taxed',10,4)->default('0');

            // 后期字段
            $table->integer('is_modified')->default('0');
            $table->integer('is_long')->default('0');
            $table->integer('is_short')->default('0');
            $table->datetime('last_gnr_stop_time')->nullable();
            $table->integer('interval_time')->default('0');

            $table->integer('operator')->default('0');
            $table->timestamps();
        });

        // 站点相关的基准价格、场地费，电力引入费，扣费
        Schema::create('fee_out_site', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('out_id')->default('0')->index();
            $table->string('site_code')->index();
            $table->string('start_day');
            $table->string('end_day');
            // 基准价格
            $table->double('fee_basic',10,4)->default('0');
            $table->double('fee_basic_taxed',10,4)->default('0');

            // 场地费
            $table->double('fee_site',10,4)->default('0');
            $table->double('fee_site_taxed',10,4)->default('0');

            // 电力引入费
            $table->double('fee_import',10,4)->default('0');
            $table->double('fee_import_taxed',10,4)->default('0');

            // 扣费
            $table->double('fee_cut',10,4)->default('0');
            $table->double('fee_cut_taxed',10,4)->default('0');

            $table->integer('operator');
            $table->timestamps();
        });

        // 站点单价
        Schema::create('fee_out_site_price', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('site_code')->index();

            // 基准价格
            $table->double('fee_basic',10,4)->default('0');
            $table->double('fee_basic_taxed',10,4)->default('0');

            // 场地费
            $table->double('fee_site',10,4)->default('0');
            $table->double('fee_site_taxed',10,4)->default('0');

            // 电力引入费
            $table->double('fee_import',10,4)->default('0');
            $table->double('fee_import_taxed',10,4)->default('0');

            $table->timestamps();
        });

        // 配置项，如发电时长
        Schema::create('setting', function(Blueprint $table)
        {
            $table->string('name')->primary();
            $table->text('value')->nullable();

        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('fee_out');
        Schema::drop('fee_out_elec');
        Schema::drop('fee_out_gnr');
        Schema::drop('fee_out_site');
        Schema::drop('fee_out_site_price');
        Schema::drop('setting');
    }
}
