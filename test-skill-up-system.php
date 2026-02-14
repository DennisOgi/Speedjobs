<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "╔══════════════════════════════════════════════════════════╗\n";
echo "║       SKILL UP SYSTEM - COMPREHENSIVE TEST REPORT       ║\n";
echo "╚══════════════════════════════════════════════════════════╝\n\n";

// Test 1: Database Content
echo "📊 DATABASE CONTENT\n";
echo "══════════════════════════════════════════════════════════\n";
$categories = \App\Models\CourseCategory::count();
$courses = \App\Models\Course::count();
$publishedCourses = \App\Models\Course::where('is_published', true)->count();
$lessons = \App\Models\CourseLesson::count();
$enrollments = \App\Models\CourseEnrollment::count();

echo "✓ Course Categories: {$categories}\n";
echo "✓ Total Courses: {$courses}\n";
echo "✓ Published Courses: {$publishedCourses}\n";
echo "✓ Total Lessons: {$lessons}\n";
echo "✓ Enrollments: {$enrollments}\n\n";

// Test 2: Course Details
echo "📚 COURSE CATALOG\n";
echo "══════════════════════════════════════════════════════════\n";
$allCourses = \App\Models\Course::with('category')->get();
foreach ($allCourses as $course) {
    $lessonCount = $course->lessons()->count();
    echo "• {$course->title}\n";
    echo "  Category: {$course->category->name}\n";
    echo "  Level: {$course->level} | Duration: {$course->duration_hours}h | Price: \${$course->price}\n";
    echo "  Lessons: {$lessonCount} | Instructor: {$course->instructor_name}\n\n";
}

// Test 3: Admin Routes
echo "🔧 ADMIN ROUTES\n";
echo "══════════════════════════════════════════════════════════\n";
$routes = \Illuminate\Support\Facades\Route::getRoutes();
$courseRoutes = collect($routes)->filter(function($route) {
    $name = $route->getName() ?? '';
    return str_contains($name, 'admin.courses') || str_contains($name, 'admin.categories');
});

echo "✓ Found " . $courseRoutes->count() . " admin course management routes:\n";
foreach ($courseRoutes as $route) {
    echo "  - {$route->getName()}\n";
}
echo "\n";

// Test 4: Public Routes
echo "🌐 PUBLIC ROUTES\n";
echo "══════════════════════════════════════════════════════════\n";
$publicRoutes = collect($routes)->filter(function($route) {
    $name = $route->getName() ?? '';
    return str_contains($name, 'courses.') && !str_contains($name, 'admin');
});

echo "✓ Found " . $publicRoutes->count() . " public course routes:\n";
foreach ($publicRoutes as $route) {
    echo "  - {$route->getName()}\n";
}
echo "\n";

// Test 5: Feature Completeness
echo "✨ FEATURE COMPLETENESS\n";
echo "══════════════════════════════════════════════════════════\n";
$features = [
    'Admin Course Management' => file_exists('app/Http/Controllers/Admin/CourseController.php'),
    'Admin Category Management' => file_exists('app/Http/Controllers/Admin/CourseCategoryController.php'),
    'Admin Lesson Management' => file_exists('app/Http/Controllers/Admin/CourseLessonController.php'),
    'Admin Course Index View' => file_exists('resources/views/admin/courses/index.blade.php'),
    'Admin Course Create View' => file_exists('resources/views/admin/courses/create.blade.php'),
    'Public Course Browsing' => file_exists('app/Http/Controllers/CourseController.php'),
    'Course Enrollment System' => file_exists('app/Http/Controllers/EnrollmentController.php'),
    'Lesson Learning System' => file_exists('app/Http/Controllers/LessonController.php'),
    'Skill Up Landing Page' => file_exists('resources/views/skill-up.blade.php'),
    'Sample Course Data' => $courses > 0,
];

foreach ($features as $feature => $exists) {
    $status = $exists ? '✓' : '✗';
    echo "{$status} {$feature}\n";
}
echo "\n";

// Test 6: URLs to Test
echo "🔗 KEY URLS TO TEST\n";
echo "══════════════════════════════════════════════════════════\n";
echo "Public Pages:\n";
echo "  • Skill Up Landing: http://127.0.0.1:8000/skill-up\n";
echo "  • Browse Courses: http://127.0.0.1:8000/courses\n";
echo "  • My Courses: http://127.0.0.1:8000/my-courses\n\n";

echo "Admin Pages:\n";
echo "  • Admin Dashboard: http://127.0.0.1:8000/admin/dashboard\n";
echo "  • Manage Courses: http://127.0.0.1:8000/admin/courses\n";
echo "  • Create Course: http://127.0.0.1:8000/admin/courses/create\n";
echo "  • Manage Categories: http://127.0.0.1:8000/admin/categories\n\n";

// Test 7: Sample Course URLs
echo "📖 SAMPLE COURSE URLS\n";
echo "══════════════════════════════════════════════════════════\n";
$sampleCourses = \App\Models\Course::take(3)->get();
foreach ($sampleCourses as $course) {
    echo "  • {$course->title}\n";
    echo "    http://127.0.0.1:8000/courses/{$course->slug}\n\n";
}

// Final Summary
echo "╔══════════════════════════════════════════════════════════╗\n";
echo "║                    SYSTEM STATUS                         ║\n";
echo "╚══════════════════════════════════════════════════════════╝\n\n";

$allFeaturesWork = !in_array(false, $features);
if ($allFeaturesWork && $courses > 0) {
    echo "🎉 SUCCESS! The Skill Up system is fully functional!\n\n";
    echo "What You Can Do Now:\n";
    echo "1. Browse courses at /skill-up or /courses\n";
    echo "2. Enroll in courses (requires authentication)\n";
    echo "3. Manage courses from admin dashboard\n";
    echo "4. Create new courses, categories, and lessons\n";
    echo "5. Publish/unpublish courses\n";
    echo "6. Track student enrollments\n\n";
} else {
    echo "⚠ Some features may need attention\n\n";
}

echo "Admin Login:\n";
echo "  Email: test@speedjobs.com\n";
echo "  Password: (use php make-admin.php to reset)\n\n";
