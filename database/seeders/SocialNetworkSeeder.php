<?php

namespace Database\Seeders;

use App\Models\SocialNetwork;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SocialNetworkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('social_networks')->insert([
            "name" => "Facebook",
            "value" => "@tecnologico.sucua.5",
            "url" => "https://www.facebook.com/tecnologico.sucua.5",
            "icon" => '<svg viewBox="0 0 512 512"><path d="M512 256C512 114.6 397.4 0 256 0S0 114.6 0 256C0 376 82.7 476.8 194.2 504.5V334.2H141.4V256h52.8V222.3c0-87.1 39.4-127.5 125-127.5c16.2 0 44.2 3.2 55.7 6.4V172c-6-.6-16.5-1-29.6-1c-42 0-58.2 15.9-58.2 57.2V256h83.6l-14.4 78.2H287V510.1C413.8 494.8 512 386.9 512 256h0z"/></svg>',
            "color" => "#0866ff",
            "color2" => "#0084ff",
        ]);

        DB::table('social_networks')->insert([
            "name" => "Telefono",
            "value" => "(07)2740-421",
            "url" => "tel:(07)2740-421",
            "icon" => '<svg viewBox="0 0 512 512"><path d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"/></svg>',
            "color" => "#2672de",
            "color2" => "#229fdd",
        ]);
    }
}
