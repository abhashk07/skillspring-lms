<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            ['Laravel Basics', 'Learn Laravel fundamentals from scratch', 1999],
            ['Advanced Laravel', 'Deep dive into Laravel internals', 2999],
            ['PHP for Beginners', 'Core PHP concepts and syntax', 1499],
            ['REST API with Laravel', 'Build APIs using Laravel', 2499],
            ['Authentication in Laravel', 'Auth, roles & permissions', 1999],
            ['Laravel Eloquent Mastery', 'Master Eloquent ORM', 2199],
            ['Laravel Blade & UI', 'Blade templates & UI patterns', 1799],
            ['Laravel Performance', 'Optimize Laravel applications', 2599],
            ['Laravel Security', 'Security best practices', 2299],
            ['Laravel Testing', 'Unit & feature testing', 1999],
        ];

        for ($i = 1; $i <= 100; $i++) {
            $course = $courses[array_rand($courses)];

            Course::create([
                'title' => $course[0] . " #{$i}",
                'description' => $course[1],
                'price' => $course[2],
            ]);
        }
    }
}
