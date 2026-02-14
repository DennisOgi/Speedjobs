<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResumeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $banners = \App\Models\Banner::active()->get();
    $recentJobs = \App\Models\Job::latest()->take(6)->get();
    $featuredJobs = \App\Models\Job::where('is_featured', true)->latest()->take(4)->get();
    return view('welcome', compact('banners', 'recentJobs', 'featuredJobs'));
})->name('welcome');

Route::get('/dashboard', [\App\Http\Controllers\JobseekerDashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Employer Routes
    Route::get('/employer/dashboard', [\App\Http\Controllers\EmployerDashboardController::class, 'index'])->name('employer.dashboard');
    Route::get('/employer/jobs', [\App\Http\Controllers\EmployerDashboardController::class, 'jobs'])->name('employer.jobs.index');
    Route::get('/employer/jobs/{job}/edit', [\App\Http\Controllers\EmployerDashboardController::class, 'editJob'])->name('employer.jobs.edit');
    Route::put('/employer/jobs/{job}', [\App\Http\Controllers\EmployerDashboardController::class, 'updateJob'])->name('employer.jobs.update');
    Route::delete('/employer/jobs/{job}', [\App\Http\Controllers\EmployerDashboardController::class, 'destroyJob'])->name('employer.jobs.destroy');
    Route::get('/employer/applications/{job?}', [\App\Http\Controllers\EmployerDashboardController::class, 'applications'])->name('employer.applications.index');
    Route::get('/employer/applications/{application}/show', [\App\Http\Controllers\EmployerDashboardController::class, 'showApplication'])->name('employer.applications.show');
    Route::patch('/employer/applications/{application}/status', [\App\Http\Controllers\EmployerDashboardController::class, 'updateApplicationStatus'])->name('employer.applications.status');
    Route::patch('/employer/applications/{application}/notes', [\App\Http\Controllers\EmployerDashboardController::class, 'updateApplicationNotes'])->name('employer.applications.notes');

    // Resume Builder
    Route::get('/resume', [ResumeController::class, 'index'])->name('resume.index');
    Route::get('/resume/create', [ResumeController::class, 'create'])->name('resume.create');
    Route::post('/resume', [ResumeController::class, 'store'])->name('resume.store');
    Route::get('/resume/{resume}/edit', [ResumeController::class, 'edit'])->name('resume.edit');
    Route::put('/resume/{resume}', [ResumeController::class, 'update'])->name('resume.update');
    Route::delete('/resume/{resume}', [ResumeController::class, 'destroy'])->name('resume.destroy');
    Route::post('/resume/{resume}/autosave', [ResumeController::class, 'autosave'])->name('resume.autosave');
    Route::post('/resume/{resume}/photo', [ResumeController::class, 'uploadPhoto'])->name('resume.photo.upload');
    Route::delete('/resume/{resume}/photo', [ResumeController::class, 'removePhoto'])->name('resume.photo.remove');
    Route::post('/resume/{resume}/duplicate', [ResumeController::class, 'duplicate'])->name('resume.duplicate');
    Route::get('/resume/{resume}/preview', [ResumeController::class, 'preview'])->name('resume.preview');
    Route::get('/resume/{resume}/download', [ResumeController::class, 'download'])->name('resume.download');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('banners', \App\Http\Controllers\AdminBannerController::class);
    Route::resource('resources', \App\Http\Controllers\Admin\ResourceController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    
    // Course Management
    Route::resource('courses', \App\Http\Controllers\Admin\CourseController::class);
    Route::get('/courses/{course}/lessons', [\App\Http\Controllers\Admin\CourseController::class, 'lessons'])->name('courses.lessons');
    Route::get('/courses/{course}/lessons/create', [\App\Http\Controllers\Admin\CourseLessonController::class, 'create'])->name('courses.lessons.create');
    Route::post('/courses/{course}/lessons', [\App\Http\Controllers\Admin\CourseLessonController::class, 'store'])->name('courses.lessons.store');
    Route::get('/courses/{course}/lessons/{lesson}/edit', [\App\Http\Controllers\Admin\CourseLessonController::class, 'edit'])->name('courses.lessons.edit');
    Route::put('/courses/{course}/lessons/{lesson}', [\App\Http\Controllers\Admin\CourseLessonController::class, 'update'])->name('courses.lessons.update');
    Route::delete('/courses/{course}/lessons/{lesson}', [\App\Http\Controllers\Admin\CourseLessonController::class, 'destroy'])->name('courses.lessons.destroy');
    
    // Course Categories
    Route::resource('course-categories', \App\Http\Controllers\Admin\CourseCategoryController::class)->except(['show', 'create', 'edit']);
    Route::get('/courses/{course}/lessons/{lesson}/edit', [\App\Http\Controllers\Admin\CourseLessonController::class, 'edit'])->name('courses.lessons.edit');
    Route::put('/courses/{course}/lessons/{lesson}', [\App\Http\Controllers\Admin\CourseLessonController::class, 'update'])->name('courses.lessons.update');
    Route::delete('/courses/{course}/lessons/{lesson}', [\App\Http\Controllers\Admin\CourseLessonController::class, 'destroy'])->name('courses.lessons.destroy');
    
    // Course Categories
    Route::resource('course-categories', \App\Http\Controllers\Admin\CourseCategoryController::class)->except(['show', 'create', 'edit']);
    Route::get('/courses/{course}/lessons/{lesson}/edit', [\App\Http\Controllers\Admin\CourseLessonController::class, 'edit'])->name('courses.lessons.edit');
    Route::put('/courses/{course}/lessons/{lesson}', [\App\Http\Controllers\Admin\CourseLessonController::class, 'update'])->name('courses.lessons.update');
    Route::delete('/courses/{course}/lessons/{lesson}', [\App\Http\Controllers\Admin\CourseLessonController::class, 'destroy'])->name('courses.lessons.destroy');
    Route::resource('course-categories', \App\Http\Controllers\Admin\CourseCategoryController::class)->except(['create', 'show', 'edit']);
    
    // Counseling Requests (Admin)
    Route::get('/counseling', [\App\Http\Controllers\Admin\CounselingRequestController::class, 'index'])->name('counseling.index');
    Route::get('/counseling/{counselingRequest}', [\App\Http\Controllers\Admin\CounselingRequestController::class, 'show'])->name('counseling.show');
    Route::post('/counseling/{counselingRequest}/assign', [\App\Http\Controllers\Admin\CounselingRequestController::class, 'assign'])->name('counseling.assign');
});
Route::resource('jobs', \App\Http\Controllers\JobController::class)->only(['index', 'show', 'create', 'store']);

// Course Routes (Moved to Gated Section)

// Authenticated Course Routes
Route::middleware('auth')->group(function () {
    Route::post('/courses/{course}/enroll', [\App\Http\Controllers\EnrollmentController::class, 'enroll'])->name('courses.enroll');
    Route::get('/my-courses', [\App\Http\Controllers\EnrollmentController::class, 'myCourses'])->name('courses.my-courses');
    Route::get('/courses/{course:slug}/learn/{lesson:slug?}', [\App\Http\Controllers\LessonController::class, 'show'])->name('courses.learn');

    // Counselor Routes
    Route::get('/counselors', [\App\Http\Controllers\CounselorController::class, 'index'])->name('counselors.index');
    Route::get('/counselors/{counselor}', [\App\Http\Controllers\CounselorController::class, 'show'])->name('counselors.show');
    Route::post('/counselors/{counselor}/book', [\App\Http\Controllers\BookingController::class, 'store'])->name('counselors.book');
    Route::get('/my-bookings', [\App\Http\Controllers\BookingController::class, 'myBookings'])->name('counselors.my-bookings');

    // Counseling Requests (User) - Requires auth only, paid check in view
    Route::get('/counseling', [\App\Http\Controllers\CounselingRequestController::class, 'index'])->name('counseling.index');
    Route::get('/counseling/apply', [\App\Http\Controllers\CounselingRequestController::class, 'create'])->name('counseling.create');
    Route::post('/counseling', [\App\Http\Controllers\CounselingRequestController::class, 'store'])->name('counseling.store');
});

// NEW AI Career Counselor (Structured Sessions)
Route::prefix('ai-counselor')->name('ai-counselor.')->middleware(['auth', 'throttle:200,60'])->group(function () {
    Route::get('/', [\App\Http\Controllers\AiSessionController::class, 'index'])->name('index');
    Route::post('/start', [\App\Http\Controllers\AiSessionController::class, 'startSession'])->name('start');
    Route::get('/session/{session}', [\App\Http\Controllers\AiSessionController::class, 'showSession'])->name('session');
    Route::post('/session/{session}/submit', [\App\Http\Controllers\AiSessionController::class, 'submitStep'])->name('submit');
    Route::get('/report/{session}', [\App\Http\Controllers\AiSessionController::class, 'showReport'])->name('report');
    
    // Legacy endpoints (keep for backward compatibility with widget until fully removed)
    Route::get('/create', [\App\Http\Controllers\AiCounselorController::class, 'createConversation'])->name('create');
    Route::get('/analyze-job/{job}', [\App\Http\Controllers\AiCounselorController::class, 'analyzeJob'])->name('analyze-job');
    Route::get('/profile-report', [\App\Http\Controllers\AiCounselorController::class, 'profileReport'])->name('profile-report');
});


// Assessment Routes - Public Access for Testing
Route::prefix('assessments')->name('assessments.')->middleware('throttle:100,60')->group(function () {
    Route::get('/', [\App\Http\Controllers\AssessmentController::class, 'index'])->name('index');
    Route::get('/{type}', [\App\Http\Controllers\AssessmentController::class, 'show'])->name('show');
    Route::post('/{type}/submit', [\App\Http\Controllers\AssessmentController::class, 'submit'])->name('submit');
    Route::get('/results/{result}', [\App\Http\Controllers\AssessmentController::class, 'results'])->name('results');
    Route::get('/results/{result}/download', [\App\Http\Controllers\AssessmentController::class, 'download'])->name('download');
});

// Career Pathway Routes - Public Access for Testing
Route::prefix('career-pathways')->name('pathways.')->middleware('throttle:100,60')->group(function () {
    Route::get('/', [\App\Http\Controllers\CareerPathwayController::class, 'index'])->name('index');
    Route::get('/create', [\App\Http\Controllers\CareerPathwayController::class, 'create'])->name('create');
    Route::post('/', [\App\Http\Controllers\CareerPathwayController::class, 'store'])->name('store');
    Route::get('/{pathway}', [\App\Http\Controllers\CareerPathwayController::class, 'show'])->name('show');
    Route::post('/{pathway}/update-progress', [\App\Http\Controllers\CareerPathwayController::class, 'updateProgress'])->name('update-progress');
    Route::delete('/{pathway}', [\App\Http\Controllers\CareerPathwayController::class, 'destroy'])->name('destroy');
});

// Resume Analysis Routes - Public Access for Testing
Route::prefix('resume-analysis')->name('resume-analysis.')->middleware('throttle:100,60')->group(function () {
    Route::get('/', [\App\Http\Controllers\ResumeAnalysisController::class, 'index'])->name('index');
    Route::post('/upload', [\App\Http\Controllers\ResumeAnalysisController::class, 'upload'])->name('upload');
    Route::get('/{analysis}', [\App\Http\Controllers\ResumeAnalysisController::class, 'show'])->name('show');
    Route::delete('/{analysis}', [\App\Http\Controllers\ResumeAnalysisController::class, 'destroy'])->name('destroy');
});

// Interview Coach Routes - Public Access for Testing
Route::prefix('interview-coach')->name('interview-coach.')->middleware('throttle:100,60')->group(function () {
    Route::get('/', [\App\Http\Controllers\InterviewCoachController::class, 'index'])->name('index');
    Route::get('/practice', [\App\Http\Controllers\InterviewCoachController::class, 'practice'])->name('practice');
    Route::post('/generate-questions', [\App\Http\Controllers\InterviewCoachController::class, 'generateQuestions'])->name('generate-questions');
    Route::post('/evaluate-answer', [\App\Http\Controllers\InterviewCoachController::class, 'evaluateAnswer'])->name('evaluate-answer');
    Route::get('/history', [\App\Http\Controllers\InterviewCoachController::class, 'history'])->name('history');
});

// Premium Features - Paid Users Only
Route::middleware(['auth', 'paid'])->group(function () {

    // Career Planning Tool
    Route::get('/career-planning', [\App\Http\Controllers\CareerPlanningController::class, 'index'])->name('career-planning.index');
    Route::post('/career-planning', [\App\Http\Controllers\CareerPlanningController::class, 'store'])->name('career-planning.store');

    // Career Assessment
    Route::get('/career-assessment', function () {
        return view('career-assessment');
    })->name('career-assessment');

    // Interview Coaching
    Route::get('/interview-coaching', function () {
        return view('interview-coaching');
    })->name('interview-coaching');

    // Mentorship Program
    Route::get('/mentorship', function () {
        return view('mentorship');
    })->name('mentorship');
    
    // Mentor Application Routes
    Route::get('/mentorship/apply', [\App\Http\Controllers\MentorApplicationController::class, 'create'])->name('mentorship.apply');
    Route::post('/mentorship/apply', [\App\Http\Controllers\MentorApplicationController::class, 'store'])->name('mentorship.store');
    Route::get('/my-mentor-application', [\App\Http\Controllers\MentorApplicationController::class, 'myApplication'])->name('mentorship.my-application');

    // Career Workshops (legacy route - redirects to new workshops)
    // Route::get('/workshops', function () {
    //     return view('workshops');
    // })->name('workshops.legacy');

    // Job Applications
    Route::get('/my-applications', [\App\Http\Controllers\JobApplicationController::class, 'index'])->name('applications.index');
    Route::post('/jobs/{job}/apply', [\App\Http\Controllers\JobApplicationController::class, 'store'])->name('jobs.apply');
    Route::post('/applications/{application}/withdraw', [\App\Http\Controllers\JobApplicationController::class, 'withdraw'])->name('applications.withdraw');

    // Saved Jobs
    Route::get('/saved-jobs', [\App\Http\Controllers\SavedJobController::class, 'index'])->name('saved-jobs.index');
    Route::post('/jobs/{job}/save', [\App\Http\Controllers\SavedJobController::class, 'store'])->name('jobs.save');
    Route::delete('/jobs/{job}/unsave', [\App\Http\Controllers\SavedJobController::class, 'destroy'])->name('jobs.unsave');
});

// Payment Routes
Route::get('/payment/callback', [\App\Http\Controllers\PaymentController::class, 'callback'])->name('payment.callback');


// Career Services & Skill Up (Public pages with feature-level gating)
Route::view('/career-services', 'career-services')->name('career-services');
Route::get('/skill-up', [\App\Http\Controllers\CourseController::class, 'index'])->name('skill-up');
Route::view('/career-advice', 'career-advice')->name('career-advice');
Route::view('/skill-assessments', 'skill-assessments')->name('skill-assessments');

Route::middleware('auth')->group(function () {
    // ... other auth routes if any were here, but it seems empty now so I will just close the previous group if needed or just remove the wrapping group
});

// Course Routes (Public access, enrollment gated)
Route::get('/courses', [\App\Http\Controllers\CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course:slug}', [\App\Http\Controllers\CourseController::class, 'show'])->name('courses.show');

Route::view('/browse-candidates', 'browse-candidates')->name('browse-candidates');

Route::view('/about', 'about')->name('about');

// Contact Routes
Route::get('/contact', [\App\Http\Controllers\ContactController::class, 'index'])->name('contact');
Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

// Banner Applications (User) - Auth required
Route::middleware('auth')->group(function () {
    Route::post('/banners/{banner}/apply', [\App\Http\Controllers\BannerApplicationController::class, 'apply'])->name('banners.apply');
    Route::get('/my-banner-applications', [\App\Http\Controllers\BannerApplicationController::class, 'myApplications'])->name('banner-applications.index');
});

// Admin Workshop Routes - REMOVED (Use Banners instead)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Banner Applications (Admin)
    Route::get('banner-applications', [\App\Http\Controllers\Admin\BannerApplicationController::class, 'index'])->name('banner-applications.index');
    Route::get('banner-applications/{application}', [\App\Http\Controllers\Admin\BannerApplicationController::class, 'show'])->name('banner-applications.show');
    Route::post('banner-applications/{application}/approve', [\App\Http\Controllers\Admin\BannerApplicationController::class, 'approve'])->name('banner-applications.approve');
    Route::post('banner-applications/{application}/reject', [\App\Http\Controllers\Admin\BannerApplicationController::class, 'reject'])->name('banner-applications.reject');
    
    // Mentor Applications (Admin)
    Route::get('mentor-applications', [\App\Http\Controllers\Admin\MentorApplicationController::class, 'index'])->name('mentor-applications.index');
    Route::get('mentor-applications/{application}', [\App\Http\Controllers\Admin\MentorApplicationController::class, 'show'])->name('mentor-applications.show');
    Route::post('mentor-applications/{application}/approve', [\App\Http\Controllers\Admin\MentorApplicationController::class, 'approve'])->name('mentor-applications.approve');
    Route::post('mentor-applications/{application}/reject', [\App\Http\Controllers\Admin\MentorApplicationController::class, 'reject'])->name('mentor-applications.reject');
});

require __DIR__.'/auth.php';
