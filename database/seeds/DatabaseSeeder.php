<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*添加默认权限组*/
        DB::table('roles')->insert([
            ['id' => '1','name' => '后台管理员','slug' => 'admin','description' => '后台管理员，具有最高权限','level'=>1,'created_at'=>'2016-02-16 09:52:13','updated_at'=>'2016-02-16 09:52:13'],
            ['id' => '2','name' => '普通会员','slug' => 'member','description' => '普通会员，不可管理后台','level'=>1,'created_at'=>'2016-02-16 09:52:13','updated_at'=>'2016-02-16 09:52:13'],
        ]);

        DB::table('permissions')->insert([
            ['id' => '1','name' => '后台管理首页','slug' => 'admin.index.index','description' => '后台管理首页','created_at'=>'2016-02-16 17:57:51','updated_at'=>'2016-02-16 17:57:51'],
        ]);

        DB::table('permission_role')->insert([
            ['id' => '1','permission_id' => '1','role_id' => '1','created_at'=>'2016-02-16 17:37:51','updated_at'=>'2016-04-16 17:57:51'],
        ]);

        DB::table('users')->insert([
            ['id' => '1','name' => 'alexv', 'email' => 'alexv1@163.com', 'password' => '$2y$10$dXLgM.herHy7AKd7OpmlzuKAsRbkbhazmoAAqatmz/OfRrd.wWER2', 'created_at'=>'2016-02-16 17:37:51','updated_at'=>'2016-04-16 17:57:51'],
        ]);

        DB::table('role_user')->insert([
            ['role_id' => '1', 'user_id' => '1', 'created_at'=>'2016-02-16 17:37:51','updated_at'=>'2016-04-16 17:57:51'],
        ]);

        /*系统默认配置*/
        DB::table('settings')->insert([
            // 超长/超短发电的门限，单位分钟
            ['name' => 'gnr_long_threshold','value' => '300'],
            ['name' => 'gnr_short_threshold','value' => '30']
        ]);

        DB::table('fee_out_site_price')->insert([
            // 超长/超短发电的门限，单位分钟
            ['site_code' => '420300908000000233','fee_basic' => '10000.0000','fee_basic_taxed' => '10600.00','fee_site' => '5000.0000','fee_site_taxed' => '5300.0000','fee_import' => '12000.0000','fee_import_taxed' => '1400.00000','created_at' => '2016-02-16 17:57:51','updated_at' => '2016-02-16 17:57:51'],
        ]);

    }
}
