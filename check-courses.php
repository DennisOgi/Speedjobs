<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Checking Skill Up / Courses System\n";
echo "===================================\n\n";

// Check courses
$courses = \App\Models\Course::count();
$publishedCourses = \App\Models\Course::where('is_published', true)->count();
echo "Total Courses: {$courses}\n";
echo "Published Courses: {$publishedCourses}\n";

// Check categories
$categories = \App\Models\CourseCategory::count();
echo "Course Categories: {$categories}\n";

// Check enrollments
$enrollments = \App\Models\CourseEnrollment::count();
echo "Total Enrollments: {$enrollments}\n";

echo "\n";
if ($courses === 0) {
    echo "⚠ No courses found in database\n";
    echo "The Skill Up page is a static landing page that links to courses\n";
    echo "Courses need to be seeded or created via admin panel\n";
} else {
    echo "✓ Courses system has data\n";
}
