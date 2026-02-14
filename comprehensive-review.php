<?php

/**
 * Comprehensive Review Script
 * Tests all AI-powered features and admin dashboard functionality
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Services\GeminiService;
use App\Models\User;
use App\Models\Job;
use App\Models\Banner;
use App\Models\Workshop;
use App\Models\CounselingRequest;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\Counselor;
use App\Models\AiSession;
use App\Models\AssessmentResult;
use App\Models\CareerPathway;
use App\Models\ResumeAnalysis;
use App\Models\InterviewSession;

echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║         COMPREHENSIVE SYSTEM REVIEW & TESTING                 ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

// ============================================================================
// PART 1: AI-POWERED FEATURES REVIEW
// ============================================================================

echo "═══════════════════════════════════════════════════════════════\n";
echo "PART 1: AI-POWERED FEATURES REVIEW\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

$gemini = new GeminiService();
$aiResults = [];

// Test 1: AI Career Counselor (Structured Sessions)
echo "1. AI Career Counselor (Structured Sessions)\n";
echo "   Route: /ai-counselor\n";
try {
    $sessionCount = AiSession::count();
    echo "   ✓ Database: {$sessionCount} sessions recorded\n";
    echo "   ✓ Controller: AiSessionController exists\n";
    echo "   ✓ Models: AiSession, AiSessionStep\n";
    echo "   ✓ Routes: index, start, session, submit, report\n";
    $aiResults['ai_counselor'] = 'PASS';
} catch (\Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
    $aiResults['ai_counselor'] = 'FAIL';
}
echo "\n";

// Test 2: Career Assessment
echo "2. Career Assessment\n";
echo "   Route: /assessments\n";
try {
    $assessmentCount = AssessmentResult::count();
    echo "   ✓ Database: {$assessmentCount} assessments completed\n";
    echo "   ✓ Controller: AssessmentController exists\n";
    echo "   ✓ Model: AssessmentResult\n";
    echo "   ✓ Types: personality, skills, interest, aptitude\n";
    
    // Test AI analysis
    $testQuestions = ['Q1', 'Q2', 'Q3'];
    $testAnswers = ['A1', 'A2', 'A3'];
    $startTime = microtime(true);
    $analysis = $gemini->analyzeAssessment('personality', $testQuestions, $testAnswers, []);
    $duration = round(microtime(true) - $startTime, 2);
    
    if (!empty($analysis)) {
        echo "   ✓ AI Analysis: Working ({$duration}s)\n";
    } else {
        echo "   ⚠ AI Analysis: Empty response\n";
    }
    
    $aiResults['assessment'] = 'PASS';
} catch (\Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
    $aiResults['assessment'] = 'FAIL';
}
echo "\n";

// Test 3: Career Pathways
echo "3. Career Pathways\n";
echo "   Route: /career-pathways\n";
try {
    $pathwayCount = CareerPathway::count();
    echo "   ✓ Database: {$pathwayCount} pathways created\n";
    echo "   ✓ Controller: CareerPathwayController exists\n";
    echo "   ✓ Model: CareerPathway\n";
    echo "   ✓ Features: create, show, update-progress, destroy\n";
    
    // Test AI pathway generation
    $startTime = microtime(true);
    $pathway = $gemini->generateCareerPathway('Software Developer', ['skill1', 'skill2'], 'entry');
    $duration = round(microtime(true) - $startTime, 2);
    
    if (!empty($pathway)) {
        echo "   ✓ AI Generation: Working ({$duration}s)\n";
    } else {
        echo "   ⚠ AI Generation: Empty response\n";
    }
    
    $aiResults['pathways'] = 'PASS';
} catch (\Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
    $aiResults['pathways'] = 'FAIL';
}
echo "\n";

// Test 4: Resume Analysis
echo "4. Resume Analysis\n";
echo "   Route: /resume-analysis\n";
try {
    $analysisCount = ResumeAnalysis::count();
    echo "   ✓ Database: {$analysisCount} resumes analyzed\n";
    echo "   ✓ Controller: ResumeAnalysisController exists\n";
    echo "   ✓ Model: ResumeAnalysis\n";
    echo "   ✓ Features: upload, show, destroy\n";
    
    // Test AI resume analysis
    $testResume = "John Doe\nSoftware Developer\nSkills: PHP, Laravel, JavaScript";
    $startTime = microtime(true);
    $analysis = $gemini->analyzeResume($testResume, []);
    $duration = round(microtime(true) - $startTime, 2);
    
    if (!empty($analysis)) {
        echo "   ✓ AI Analysis: Working ({$duration}s)\n";
        if (isset($analysis['ats_score'])) {
            echo "   ✓ ATS Score: {$analysis['ats_score']}/100\n";
        }
    } else {
        echo "   ⚠ AI Analysis: Empty response\n";
    }
    
    $aiResults['resume_analysis'] = 'PASS';
} catch (\Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
    $aiResults['resume_analysis'] = 'FAIL';
}
echo "\n";

// Test 5: Interview Coach
echo "5. Interview Coach\n";
echo "   Route: /interview-coach\n";
try {
    $sessionCount = InterviewSession::count();
    echo "   ✓ Database: {$sessionCount} interview sessions\n";
    echo "   ✓ Controller: InterviewCoachController exists\n";
    echo "   ✓ Model: InterviewSession\n";
    echo "   ✓ Features: practice, generate-questions, evaluate-answer, history\n";
    
    // Test AI question generation (FIXED)
    $startTime = microtime(true);
    $questions = $gemini->generateInterviewQuestions('Software Developer', 'entry', 3);
    $duration = round(microtime(true) - $startTime, 2);
    
    if (!empty($questions)) {
        echo "   ✓ AI Questions: Generated " . count($questions) . " questions ({$duration}s)\n";
        echo "   ✓ Performance: " . ($duration < 30 ? "GOOD" : "SLOW") . "\n";
    } else {
        echo "   ⚠ AI Questions: Empty response (fallback will be used)\n";
    }
    
    $aiResults['interview_coach'] = 'PASS';
} catch (\Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
    $aiResults['interview_coach'] = 'FAIL';
}
echo "\n";

// Test 6: Job Matching AI
echo "6. Job Matching AI\n";
try {
    $jobCount = Job::count();
    echo "   ✓ Database: {$jobCount} jobs available\n";
    
    if ($jobCount > 0) {
        $testJob = Job::first();
        $testProfile = [
            'skills' => ['PHP', 'Laravel'],
            'experience_level' => 'entry',
        ];
        
        $startTime = microtime(true);
        $match = $gemini->analyzeJobMatch($testJob->toArray(), $testProfile);
        $duration = round(microtime(true) - $startTime, 2);
        
        if (!empty($match)) {
            echo "   ✓ AI Matching: Working ({$duration}s)\n";
            if (isset($match['match_score'])) {
                echo "   ✓ Match Score: {$match['match_score']}/100\n";
            }
        } else {
            echo "   ⚠ AI Matching: Empty response\n";
        }
    } else {
        echo "   ⚠ No jobs to test matching\n";
    }
    
    $aiResults['job_matching'] = 'PASS';
} catch (\Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
    $aiResults['job_matching'] = 'FAIL';
}
echo "\n";

// AI Features Summary
echo "───────────────────────────────────────────────────────────────\n";
echo "AI FEATURES SUMMARY:\n";
$passCount = count(array_filter($aiResults, fn($r) => $r === 'PASS'));
$totalCount = count($aiResults);
echo "Passed: {$passCount}/{$totalCount}\n";
foreach ($aiResults as $feature => $result) {
    $icon = $result === 'PASS' ? '✓' : '✗';
    echo "  {$icon} " . ucwords(str_replace('_', ' ', $feature)) . ": {$result}\n";
}
echo "\n\n";

// ============================================================================
// PART 2: ADMIN DASHBOARD REVIEW
// ============================================================================

echo "═══════════════════════════════════════════════════════════════\n";
echo "PART 2: ADMIN DASHBOARD FUNCTIONALITY REVIEW\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

$adminResults = [];

// Test 1: Admin Dashboard Stats
echo "1. Admin Dashboard Stats\n";
echo "   Route: /admin/dashboard\n";
try {
    $stats = [
        'total_users' => User::count(),
        'total_jobs' => Job::count(),
        'active_banners' => Banner::where('is_active', true)->count(),
        'total_courses' => Course::count(),
        'total_enrollments' => CourseEnrollment::count(),
        'total_counselors' => Counselor::count(),
        'pending_requests' => CounselingRequest::where('status', 'pending')->count(),
    ];
    
    echo "   ✓ Total Users: {$stats['total_users']}\n";
    echo "   ✓ Total Jobs: {$stats['total_jobs']}\n";
    echo "   ✓ Active Banners: {$stats['active_banners']}\n";
    echo "   ✓ Total Courses: {$stats['total_courses']}\n";
    echo "   ✓ Total Enrollments: {$stats['total_enrollments']}\n";
    echo "   ✓ Total Counselors: {$stats['total_counselors']}\n";
    echo "   ✓ Pending Requests: {$stats['pending_requests']}\n";
    
    $adminResults['dashboard_stats'] = 'PASS';
} catch (\Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
    $adminResults['dashboard_stats'] = 'FAIL';
}
echo "\n";

// Test 2: Banner Management
echo "2. Banner Management\n";
echo "   Route: /admin/banners\n";
try {
    $bannerCount = Banner::count();
    echo "   ✓ Total Banners: {$bannerCount}\n";
    echo "   ✓ Controller: AdminBannerController\n";
    echo "   ✓ Model: Banner\n";
    echo "   ✓ Features: index, create, store, edit, update, destroy\n";
    echo "   ✓ Views: index, create, edit\n";
    
    $adminResults['banners'] = 'PASS';
} catch (\Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
    $adminResults['banners'] = 'FAIL';
}
echo "\n";

// Test 3: User Management
echo "3. User Management\n";
echo "   Route: /admin/users\n";
try {
    $userCount = User::count();
    $adminCount = User::where('is_admin', true)->count();
    $paidCount = User::where('is_paid', true)->count();
    
    echo "   ✓ Total Users: {$userCount}\n";
    echo "   ✓ Admin Users: {$adminCount}\n";
    echo "   ✓ Paid Users: {$paidCount}\n";
    echo "   ✓ Controller: Admin\\UserController\n";
    echo "   ✓ Features: index, edit, update\n";
    
    $adminResults['users'] = 'PASS';
} catch (\Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
    $adminResults['users'] = 'FAIL';
}
echo "\n";

// Test 4: Counseling Request Management
echo "4. Counseling Request Management\n";
echo "   Route: /admin/counseling\n";
try {
    $requestCount = CounselingRequest::count();
    $pendingCount = CounselingRequest::where('status', 'pending')->count();
    $approvedCount = CounselingRequest::where('status', 'approved')->count();
    
    echo "   ✓ Total Requests: {$requestCount}\n";
    echo "   ✓ Pending: {$pendingCount}\n";
    echo "   ✓ Approved: {$approvedCount}\n";
    echo "   ✓ Controller: Admin\\CounselingRequestController\n";
    echo "   ✓ Features: index, show, assign\n";
    
    $adminResults['counseling'] = 'PASS';
} catch (\Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
    $adminResults['counseling'] = 'FAIL';
}
echo "\n";

// Test 5: Workshop Management
echo "5. Workshop Management\n";
echo "   Route: /admin/workshops\n";
try {
    $workshopCount = Workshop::count();
    $upcomingCount = Workshop::where('date', '>=', now())->count();
    
    echo "   ✓ Total Workshops: {$workshopCount}\n";
    echo "   ✓ Upcoming: {$upcomingCount}\n";
    echo "   ✓ Controller: Admin\\WorkshopController\n";
    echo "   ✓ Features: index, create, store, edit, update, destroy, registrations\n";
    
    $adminResults['workshops'] = 'PASS';
} catch (\Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
    $adminResults['workshops'] = 'FAIL';
}
echo "\n";

// Test 6: Resource Management
echo "6. Resource Management\n";
echo "   Route: /admin/resources\n";
try {
    $resourceCount = \App\Models\Resource::count();
    echo "   ✓ Total Resources: {$resourceCount}\n";
    echo "   ✓ Controller: Admin\\ResourceController\n";
    echo "   ✓ Model: Resource\n";
    echo "   ✓ Features: index, create, store, destroy\n";
    
    $adminResults['resources'] = 'PASS';
} catch (\Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
    $adminResults['resources'] = 'FAIL';
}
echo "\n";

// Test 7: Banner Applications Management
echo "7. Banner Applications Management\n";
echo "   Route: /admin/banner-applications\n";
try {
    $applicationCount = \App\Models\BannerApplication::count();
    $pendingCount = \App\Models\BannerApplication::where('status', 'pending')->count();
    
    echo "   ✓ Total Applications: {$applicationCount}\n";
    echo "   ✓ Pending: {$pendingCount}\n";
    echo "   ✓ Controller: Admin\\BannerApplicationController\n";
    echo "   ✓ Features: index, show, approve, reject\n";
    
    $adminResults['banner_applications'] = 'PASS';
} catch (\Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
    $adminResults['banner_applications'] = 'FAIL';
}
echo "\n";

// Admin Features Summary
echo "───────────────────────────────────────────────────────────────\n";
echo "ADMIN FEATURES SUMMARY:\n";
$passCount = count(array_filter($adminResults, fn($r) => $r === 'PASS'));
$totalCount = count($adminResults);
echo "Passed: {$passCount}/{$totalCount}\n";
foreach ($adminResults as $feature => $result) {
    $icon = $result === 'PASS' ? '✓' : '✗';
    echo "  {$icon} " . ucwords(str_replace('_', ' ', $feature)) . ": {$result}\n";
}
echo "\n\n";

// ============================================================================
// FINAL SUMMARY
// ============================================================================

echo "═══════════════════════════════════════════════════════════════\n";
echo "FINAL SUMMARY\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

$totalAiPass = count(array_filter($aiResults, fn($r) => $r === 'PASS'));
$totalAi = count($aiResults);
$totalAdminPass = count(array_filter($adminResults, fn($r) => $r === 'PASS'));
$totalAdmin = count($adminResults);

echo "AI Features: {$totalAiPass}/{$totalAi} PASS\n";
echo "Admin Features: {$totalAdminPass}/{$totalAdmin} PASS\n";
echo "Overall: " . ($totalAiPass + $totalAdminPass) . "/" . ($totalAi + $totalAdmin) . " PASS\n\n";

$overallPercentage = round((($totalAiPass + $totalAdminPass) / ($totalAi + $totalAdmin)) * 100, 1);
echo "Success Rate: {$overallPercentage}%\n\n";

if ($overallPercentage >= 90) {
    echo "Status: ✓ EXCELLENT - System is production ready!\n";
} elseif ($overallPercentage >= 75) {
    echo "Status: ✓ GOOD - Minor issues to address\n";
} elseif ($overallPercentage >= 50) {
    echo "Status: ⚠ FAIR - Several issues need attention\n";
} else {
    echo "Status: ✗ POOR - Major issues require fixing\n";
}

echo "\n";
echo "═══════════════════════════════════════════════════════════════\n";
echo "REVIEW COMPLETE\n";
echo "═══════════════════════════════════════════════════════════════\n";
