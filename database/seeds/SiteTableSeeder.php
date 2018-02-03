<?php

use Illuminate\Database\Seeder;

class SiteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Site::create([
        	'logo_url' => '#',
	        'copyright' => '#'
        ]);
    }
}
