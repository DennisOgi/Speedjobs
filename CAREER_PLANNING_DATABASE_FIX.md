# Career Planning Database Error - FIXED

## Error Encountered
```
SQLSTATE[23000]: Integrity constraint violation: 19 NOT NULL constraint failed: career_pathways.pathway_data
```

## Root Cause
The `career_pathways` table schema has a `pathway_data` JSON column that is required (NOT NULL), but the controller was trying to save individual columns (`milestones`, `skills_required`, `resources`, `ai_recommendations`, `timeline_years`) that don't exist in the table.

## Database Schema (Actual)
```php
Schema::create('career_pathways', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('current_role')->nullable();
    $table->string('target_role');
    $table->json('pathway_data');  // ← Required JSON column
    $table->integer('progress_percentage')->default(0);
    $table->enum('status', ['active', 'completed', 'abandoned'])->default('active');
    $table->timestamp('ai_generated_at');
    $table->timestamp('last_updated_at')->nullable();
    $table->timestamps();
});
```

## What Was Wrong
```php
// OLD CODE - Trying to save non-existent columns
$pathway = $user->careerPathways()->create([
    'target_role' => $request->long_term_goal,
    'current_role' => $user->experience_level ?? 'Entry Level',
    'timeline_years' => $this->extractTimelineYears($request->long_term_goal), // ❌ Column doesn't exist
    'milestones' => $parsedData['milestones'],                                  // ❌ Column doesn't exist
    'skills_required' => $parsedData['skills_required'],                        // ❌ Column doesn't exist
    'resources' => $parsedData['resources'],                                    // ❌ Column doesn't exist
    'ai_recommendations' => $aiAnalysis,                                        // ❌ Column doesn't exist
    'progress_percentage' => 0,
]);
```

## Fix Applied
```php
// NEW CODE - Store everything in pathway_data JSON column
$pathwayData = [
    'workbook_responses' => $workbookData,
    'ai_analysis' => $aiAnalysis,
    'milestones' => $parsedData['milestones'],
    'skills_required' => $parsedData['skills_required'],
    'resources' => $parsedData['resources'],
    'timeline_years' => $this->extractTimelineYears($request->long_term_goal),
    'generated_at' => now()->toDateTimeString(),
];

$pathway = $user->careerPathways()->create([
    'target_role' => $request->long_term_goal,
    'current_role' => $user->experience_level ?? 'Entry Level',
    'pathway_data' => $pathwayData,  // ✅ Store all data in JSON column
    'progress_percentage' => 0,
    'status' => 'active',
    'ai_generated_at' => now(),
]);
```

## Data Structure in pathway_data
```json
{
    "workbook_responses": {
        "strengths": "...",
        "values": "...",
        "interests": "...",
        "short_term_goal": "...",
        "long_term_goal": "...",
        "skills_gap": "...",
        "experience_gap": "...",
        "actions": ["...", "...", "..."]
    },
    "ai_analysis": "Full AI-generated career plan text...",
    "milestones": [
        "Milestone 1",
        "Milestone 2",
        "..."
    ],
    "skills_required": [
        "Skill 1",
        "Skill 2",
        "..."
    ],
    "resources": [
        "Resource 1",
        "Resource 2",
        "..."
    ],
    "timeline_years": 3,
    "generated_at": "2026-02-11 20:30:00"
}
```

## Model Configuration
The `CareerPathway` model already has proper casting:
```php
protected $casts = [
    'pathway_data' => 'array',  // ✅ Automatically converts JSON to array
    'ai_generated_at' => 'datetime',
    'last_updated_at' => 'datetime',
];
```

## Accessing Data in Views
```php
// Access pathway data
$pathway->pathway_data['ai_analysis']
$pathway->pathway_data['milestones']
$pathway->pathway_data['skills_required']
$pathway->pathway_data['resources']
$pathway->pathway_data['timeline_years']
$pathway->pathway_data['workbook_responses']
```

## Status
✅ **FIXED** - Career Planning Tool now saves correctly to database

## Testing
1. Login as paid user: `test@speedjobs.com` / `password`
2. Navigate to `/career-planning`
3. Fill out workbook form
4. Click "Save Career Plan"
5. Should redirect to pathway view without errors
6. Data should be saved in `career_pathways` table

## Files Modified
- `app/Http/Controllers/CareerPlanningController.php` - Fixed database save logic

## Date
February 11, 2026
