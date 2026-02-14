<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\CourseCategory;
use App\Models\Course;
use App\Models\CourseLesson;
use Illuminate\Support\Str;

echo "Seeding Skill Up System\n";
echo "=======================\n\n";

// Create Categories
$categories = [
    ['name' => 'Web Development', 'slug' => 'web-development', 'description' => 'Learn to build modern websites and web applications', 'order' => 1],
    ['name' => 'Data Science', 'slug' => 'data-science', 'description' => 'Master data analysis, machine learning, and AI', 'order' => 2],
    ['name' => 'Digital Marketing', 'slug' => 'digital-marketing', 'description' => 'Grow your business with digital marketing strategies', 'order' => 3],
    ['name' => 'Business & Finance', 'slug' => 'business-finance', 'description' => 'Develop business acumen and financial literacy', 'order' => 4],
    ['name' => 'Design', 'slug' => 'design', 'description' => 'Create stunning visuals and user experiences', 'order' => 5],
    ['name' => 'Personal Development', 'slug' => 'personal-development', 'description' => 'Enhance your soft skills and productivity', 'order' => 6],
];

echo "Creating categories...\n";
foreach ($categories as $category) {
    CourseCategory::create($category);
}

// Create Courses
$courses = [
    // Web Development
    [
        'category_id' => 1,
        'title' => 'Full Stack Web Development Bootcamp',
        'slug' => 'full-stack-web-development-bootcamp',
        'description' => 'Master HTML, CSS, JavaScript, React, Node.js, and MongoDB. Build 10+ real-world projects and become a professional full-stack developer.',
        'instructor_name' => 'John Doe',
        'instructor_bio' => 'Senior Full Stack Developer with 10+ years of experience at top tech companies.',
        'level' => 'beginner',
        'duration_hours' => 60,
        'price' => 49.99,
        'is_published' => true,
        'lessons' => [
            ['title' => 'Introduction to Web Development', 'content' => 'Learn the fundamentals of web development and set up your development environment.', 'duration_minutes' => 30, 'order' => 1],
            ['title' => 'HTML Basics', 'content' => 'Master HTML tags, elements, and semantic markup.', 'duration_minutes' => 45, 'order' => 2],
            ['title' => 'CSS Fundamentals', 'content' => 'Style your websites with CSS, learn layouts, flexbox, and grid.', 'duration_minutes' => 60, 'order' => 3],
            ['title' => 'JavaScript Essentials', 'content' => 'Learn JavaScript syntax, DOM manipulation, and ES6+ features.', 'duration_minutes' => 90, 'order' => 4],
            ['title' => 'React Fundamentals', 'content' => 'Build interactive UIs with React components, hooks, and state management.', 'duration_minutes' => 120, 'order' => 5],
        ]
    ],
    [
        'category_id' => 1,
        'title' => 'Advanced JavaScript & TypeScript',
        'slug' => 'advanced-javascript-typescript',
        'description' => 'Deep dive into JavaScript patterns, async programming, and TypeScript for building scalable applications.',
        'instructor_name' => 'Sarah Johnson',
        'instructor_bio' => 'JavaScript expert and technical author with multiple bestselling books.',
        'level' => 'advanced',
        'duration_hours' => 40,
        'price' => 59.99,
        'is_published' => true,
        'lessons' => [
            ['title' => 'Advanced JavaScript Patterns', 'content' => 'Master design patterns, closures, and prototypes.', 'duration_minutes' => 60, 'order' => 1],
            ['title' => 'Asynchronous JavaScript', 'content' => 'Promises, async/await, and handling concurrent operations.', 'duration_minutes' => 75, 'order' => 2],
            ['title' => 'TypeScript Fundamentals', 'content' => 'Type safety, interfaces, and generics in TypeScript.', 'duration_minutes' => 90, 'order' => 3],
        ]
    ],
    // Data Science
    [
        'category_id' => 2,
        'title' => 'Data Science & Machine Learning with Python',
        'slug' => 'data-science-machine-learning-python',
        'description' => 'Learn Python, Pandas, NumPy, Scikit-Learn, and TensorFlow. Build predictive models and analyze real-world datasets.',
        'instructor_name' => 'Dr. Alex Chen',
        'instructor_bio' => 'PhD in Computer Science, AI researcher, and data science consultant.',
        'level' => 'intermediate',
        'duration_hours' => 50,
        'price' => 69.99,
        'is_published' => true,
        'lessons' => [
            ['title' => 'Python for Data Science', 'content' => 'Python basics, NumPy arrays, and Pandas DataFrames.', 'duration_minutes' => 90, 'order' => 1],
            ['title' => 'Data Visualization', 'content' => 'Create stunning visualizations with Matplotlib and Seaborn.', 'duration_minutes' => 60, 'order' => 2],
            ['title' => 'Machine Learning Basics', 'content' => 'Supervised and unsupervised learning algorithms.', 'duration_minutes' => 120, 'order' => 3],
            ['title' => 'Deep Learning with TensorFlow', 'content' => 'Neural networks, CNNs, and RNNs for complex problems.', 'duration_minutes' => 150, 'order' => 4],
        ]
    ],
    // Digital Marketing
    [
        'category_id' => 3,
        'title' => 'Digital Marketing Masterclass 2024',
        'slug' => 'digital-marketing-masterclass-2024',
        'description' => 'Complete digital marketing course covering SEO, social media, email marketing, content marketing, and analytics.',
        'instructor_name' => 'Maria Rodriguez',
        'instructor_bio' => 'Digital marketing strategist who has helped 100+ businesses grow online.',
        'level' => 'beginner',
        'duration_hours' => 35,
        'price' => 39.99,
        'is_published' => true,
        'lessons' => [
            ['title' => 'Digital Marketing Fundamentals', 'content' => 'Overview of digital marketing channels and strategies.', 'duration_minutes' => 45, 'order' => 1],
            ['title' => 'SEO Mastery', 'content' => 'On-page and off-page SEO techniques for ranking higher.', 'duration_minutes' => 90, 'order' => 2],
            ['title' => 'Social Media Marketing', 'content' => 'Build and engage audiences on Facebook, Instagram, and LinkedIn.', 'duration_minutes' => 75, 'order' => 3],
            ['title' => 'Email Marketing', 'content' => 'Create effective email campaigns that convert.', 'duration_minutes' => 60, 'order' => 4],
        ]
    ],
    // Business & Finance
    [
        'category_id' => 4,
        'title' => 'Financial Analysis & Investment Strategies',
        'slug' => 'financial-analysis-investment-strategies',
        'description' => 'Learn financial modeling, investment analysis, and portfolio management for personal and professional growth.',
        'instructor_name' => 'David Williams',
        'instructor_bio' => 'CFA charterholder and former investment banker with 15 years of experience.',
        'level' => 'intermediate',
        'duration_hours' => 30,
        'price' => 54.99,
        'is_published' => true,
        'lessons' => [
            ['title' => 'Financial Statement Analysis', 'content' => 'Read and analyze balance sheets, income statements, and cash flows.', 'duration_minutes' => 90, 'order' => 1],
            ['title' => 'Investment Fundamentals', 'content' => 'Stocks, bonds, ETFs, and portfolio diversification.', 'duration_minutes' => 75, 'order' => 2],
            ['title' => 'Risk Management', 'content' => 'Identify and mitigate investment risks.', 'duration_minutes' => 60, 'order' => 3],
        ]
    ],
    // Design
    [
        'category_id' => 5,
        'title' => 'UI/UX Design Complete Course',
        'slug' => 'ui-ux-design-complete-course',
        'description' => 'Master user interface and user experience design. Learn Figma, design thinking, and create portfolio-worthy projects.',
        'instructor_name' => 'Emma Thompson',
        'instructor_bio' => 'Lead UX Designer at a Fortune 500 company, design mentor, and speaker.',
        'level' => 'beginner',
        'duration_hours' => 45,
        'price' => 44.99,
        'is_published' => true,
        'lessons' => [
            ['title' => 'Introduction to UI/UX', 'content' => 'Understand the difference between UI and UX design.', 'duration_minutes' => 30, 'order' => 1],
            ['title' => 'Design Thinking Process', 'content' => 'Empathize, define, ideate, prototype, and test.', 'duration_minutes' => 60, 'order' => 2],
            ['title' => 'Figma Mastery', 'content' => 'Create professional designs and prototypes in Figma.', 'duration_minutes' => 120, 'order' => 3],
            ['title' => 'User Research', 'content' => 'Conduct interviews, surveys, and usability testing.', 'duration_minutes' => 75, 'order' => 4],
        ]
    ],
    // Personal Development
    [
        'category_id' => 6,
        'title' => 'Productivity & Time Management Mastery',
        'slug' => 'productivity-time-management-mastery',
        'description' => 'Transform your productivity with proven time management techniques, goal setting, and habit formation strategies.',
        'instructor_name' => 'Michael Brown',
        'instructor_bio' => 'Productivity coach and bestselling author of "The Focused Life".',
        'level' => 'beginner',
        'duration_hours' => 20,
        'price' => 29.99,
        'is_published' => true,
        'lessons' => [
            ['title' => 'The Productivity Mindset', 'content' => 'Develop the right mindset for peak performance.', 'duration_minutes' => 45, 'order' => 1],
            ['title' => 'Time Management Techniques', 'content' => 'Pomodoro, time blocking, and priority matrices.', 'duration_minutes' => 60, 'order' => 2],
            ['title' => 'Goal Setting & Achievement', 'content' => 'SMART goals and action planning for success.', 'duration_minutes' => 50, 'order' => 3],
        ]
    ],
    [
        'category_id' => 6,
        'title' => 'Effective Communication & Leadership',
        'slug' => 'effective-communication-leadership',
        'description' => 'Develop essential communication and leadership skills for career advancement and team management.',
        'instructor_name' => 'Lisa Anderson',
        'instructor_bio' => 'Executive coach and former Fortune 100 VP of Human Resources.',
        'level' => 'intermediate',
        'duration_hours' => 25,
        'price' => 34.99,
        'is_published' => true,
        'lessons' => [
            ['title' => 'Communication Fundamentals', 'content' => 'Active listening, clear messaging, and feedback.', 'duration_minutes' => 60, 'order' => 1],
            ['title' => 'Leadership Styles', 'content' => 'Discover your leadership style and adapt to situations.', 'duration_minutes' => 75, 'order' => 2],
            ['title' => 'Conflict Resolution', 'content' => 'Handle difficult conversations and resolve conflicts.', 'duration_minutes' => 55, 'order' => 3],
        ]
    ],
];

echo "Creating courses and lessons...\n";
foreach ($courses as $courseData) {
    $lessons = $courseData['lessons'];
    unset($courseData['lessons']);
    
    $course = Course::create($courseData);
    echo "  - {$course->title}\n";
    
    foreach ($lessons as $lessonData) {
        $lessonData['course_id'] = $course->id;
        $lessonData['slug'] = Str::slug($lessonData['title']);
        CourseLesson::create($lessonData);
    }
}

echo "\n✓ Seeding complete!\n\n";

// Check results
$categories = CourseCategory::count();
$courses = Course::count();
$lessons = CourseLesson::count();

echo "Created:\n";
echo "- {$categories} Course Categories\n";
echo "- {$courses} Courses\n";
echo "- {$lessons} Lessons\n";
