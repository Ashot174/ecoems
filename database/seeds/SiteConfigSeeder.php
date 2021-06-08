<?php

use Illuminate\Database\Seeder;

use App\SiteConfig;

class SiteConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SiteConfig::create([
           'name'=>'eco.ems',
            'title'=>'eco.ems',
            'meta_keywords'=>'eco.mes,drone',
            'meta_description'=>'eco.ems',
            'email'=>'linkdemo1@linkdemo.co.in',
            'contact_email'=>'linkdemo1@linkdemo.co.in',
            'address'=>'New York City, NY - 10001 United States.',
            'phone'=>'+1 1654 2012 21',
            'site_latitude'=>'51.509865',
            'site_longitude'=>'-0.118092',
        ]);
    }
}
