# Career Planning Tool - AI Not Working

## Changes Made

### 1. Added Error Handling to Controller
Updated `app/Http/Controllers/CareerPathwayController.php` to:
- Catch exceptions from AI generation
- Log errors with context
- Show user-friendly error messages
- Validate AI response before using it

### 2. Added Error Display to Form
Updated `resources/views/pathways/create.blade.php` to:
- Display error messages prominently
- Show what went wrong
- Keep user's input so they can try again

### 3. Created Test Script
Created `test-career-pathway-ai.php` to diagnose AI issues

---

## How to Diagnose the Issue

### Step 1: Run the Test Script
```bash
php test-career-pathway-ai.php
```

This will:
- Test the AI generation directly
- Show the exact response from Gemini
- Identify missing fields
- Display any errors

### Step 2: Check Laravel Logs
```bash
tail -f storage/logs/laravel.log
```

Look for:
- "Career Pathway AI Generation Failed"
- "Gemini API returned error"
- "Gemini JSON parse error"

### Step 3: Try Creating a Pathway
1. Go to `/career-planning`
2. Fill in the form
3. Submit
4. Check what error message appears

---

## Common Issues & Solutions

### Issue 1: Empty Response from AI
**Symptoms**: Form submits but shows "AI service returned invalid data"

**Causes**:
- Gemini API key not set
- API key invalid
- Network timeout
- API rate limit reached

**Solutions**:
1. Check `.env` has `GEMINI_API_KEY=your_key_here`
2. Run `php artisan config:clear`
3. Verify API key is valid at https://aistudio.google.com/app/apikey
4. Check Railway environment variables

### Issue 2: JSON Parse Error
**Symptoms**: Logs show "Gemini JSON parse error"

**Causes**:
- AI returned text instead of JSON
- Malformed JSON response
- Response truncated

**Solutions**:
1. Check logs for the raw response
2. AI might be returning explanation text - prompt needs adjustment
3. Increase `maxOutputTokens` in the method

### Issue 3: Missing Fields
**Symptoms**: Pathway created but missing data in view

**Causes**:
- AI didn't return all required fields
- Field names don't match

**Solutions**:
1. Check the test script output
2. Update the prompt to be more specific
3. Add fallback values in controller

### Issue 4: Timeout
**Symptoms**: Request takes too long, then fails

**Causes**:
- Complex prompt
- Slow API response
- Network issues

**Solutions**:
1. Increase timeout in `sendStructuredPrompt` (currently 60s)
2. Simplify the prompt
3. Check network connectivity

---

## Testing on Railway

If it works locally but not on Railway:

### 1. Check Environment Variables
```bash
# In Railway dashboard
Settings → Variables → Check GEMINI_API_KEY exists
```

### 2. Check Railway Logs
```bash
# In Railway dashboard
Deployments → Latest → View Logs
```

Look for the same error patterns as local logs

### 3. Test API Connection
Add this temporary route to `routes/web.php`:

```php
Route::get('/test-career-ai', function() {
    $gemini = new \App\Services\GeminiService();
    $result = $gemini->generateCareerPathway(
        'Software Engineer',
        ['PHP', 'JavaScript'],
        'Junior'
    );
    return response()->json([
        'success' => !empty($result),
        'has_title' => isset($result['title']),
        'has_milestones' => isset($result['milestones']),
        'milestone_count' => count($result['milestones'] ?? []),
        'raw_keys' => array_keys($result),
    ]);
});
```

Visit `/test-career-ai` on Railway to see the response.

---

## Expected AI Response Structure

```json
{
  "title": "Path to Senior Software Engineer",
  "description": "A comprehensive pathway...",
  "duration_months": 24,
  "milestones": [
    {
      "title": "Master Advanced PHP",
      "description": "...",
      "duration_weeks": 8,
      "skills_gained": ["OOP", "Design Patterns"]
    }
  ],
  "required_skills": ["PHP", "Laravel", "Vue.js"],
  "recommended_resources": [
    {
      "type": "course",
      "title": "Advanced Laravel",
      "description": "..."
    }
  ]
}
```

---

## Quick Fixes

### If AI keeps failing, add a fallback:

In `CareerPathwayController.php`, after the try-catch:

```php
// If AI failed, create a basic pathway
if (empty($aiPathwayData)) {
    $aiPathwayData = [
        'title' => "Path to {$request->target_role}",
        'description' => "Your personalized career pathway",
        'duration_months' => 12,
        'milestones' => [
            [
                'title' => 'Build Foundation',
                'description' => 'Develop core skills',
                'duration_weeks' => 12,
                'skills_gained' => $currentSkills
            ]
        ],
        'required_skills' => $currentSkills,
        'recommended_resources' => []
    ];
}
```

---

## Next Steps

1. Run the test script to see exact error
2. Check logs for detailed error messages
3. Verify GEMINI_API_KEY is set correctly
4. Test on Railway using the test route
5. If still failing, share the error logs for further diagnosis
