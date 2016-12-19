<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=[
            [
                'link_name'=>'雅虎奇摩',
                'link_title'=>'資訊最多的網站',
                'link_url'=>'http://www.yahoo.com.tw',
                'link_order'=>1,
            ],
            [
                'link_name'=>'google',
                'link_title'=>'最好用的搜尋引擎',
                'link_url'=>'http://www.google.com',
                'link_order'=>2,
            ]
        ];
        DB::table('links')->insert($data);
    }
}
