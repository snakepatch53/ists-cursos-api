<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            SocialNetworkSeeder::class,
            ImageSeeder::class,
            InstitutionSeeder::class,
            CourseSeeder::class,
            InscriptionSeeder::class,
            StudentSeeder::class,
            TemplateSeeder::class,
            MailboxSeeder::class,
        ]);
    }
}
