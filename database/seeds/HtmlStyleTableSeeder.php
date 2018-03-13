<?php

use Illuminate\Database\Seeder;

class HtmlStyleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\HtmlStyle::create([
	        'background_color' => '#ffffff'
        ]);
    }
}
