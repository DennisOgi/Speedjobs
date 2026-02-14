<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Seeding Skill Up System\n";
echo "=======================\n\n";

$seeder = new \Database\Seeders\SkillUpSeeder();
$seeder->run();

echo "✓ Seeding complete!\n\n";

// Check results
$categories = \App\Models\CourseCategory::count();
$courses = \App\Models\Course::count();
$lessons = \App\Models\CourseLesson::count();

echo "Created:\n";
echo "- {$categories} Course Categories\n";
echo "- {$courses} Courses\n";
echo "- {$lessons} Lessons\n";
