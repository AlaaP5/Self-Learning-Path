<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('resources')->insert([
            [
                'subject_id' => 1, // لازم يكون موجود subject_id بالجدول subjects
                'title' => 'Introduction to Laravel',
                'type' => 'pdf',
                'url' => 'https://example.com/laravel-intro.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'subject_id' => 1,
                'title' => 'Laravel Video Tutorial',
                'type' => 'video',
                'url' => 'https://example.com/laravel-video.mp4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'subject_id' => 2,
                'title' => 'PHP Basics',
                'type' => 'link',
                'url' => 'https://example.com/php-basics',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'subject_id' => 2,
                'title' => 'My SQL Notes',
                'type' => 'note',
                'url' => 'These are some notes about SQL queries...',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
