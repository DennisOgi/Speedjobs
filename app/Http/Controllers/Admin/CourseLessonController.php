<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseLesson;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseLessonController extends Controller
{
    public function create(Course $course)
    {
        return view('admin.courses.lessons.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'content' => 'required|string',
            'video_url' => 'nullable|url',
            'duration' => 'nullable|string|max:50',
            'order' => 'nullable|integer|min:0',
            'is_free' => 'boolean',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);
        $validated['course_id'] = $course->id;
        $validated['order'] = $validated['order'] ?? $course->lessons()->max('order') + 1;
        $validated['is_free'] = $request->has('is_free');

        CourseLesson::create($validated);

        return redirect()->route('admin.courses.lessons', $course)
            ->with('success', 'Lesson created successfully!');
    }

    public function edit(Course $course, CourseLesson $lesson)
    {
        return view('admin.courses.lessons.edit', compact('course', 'lesson'));
    }

    public function update(Request $request, Course $course, CourseLesson $lesson)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'content' => 'required|string',
            'video_url' => 'nullable|url',
            'duration' => 'nullable|string|max:50',
            'order' => 'nullable|integer|min:0',
            'is_free' => 'boolean',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);
        $validated['is_free'] = $request->has('is_free');

        $lesson->update($validated);

        return redirect()->route('admin.courses.lessons', $course)
            ->with('success', 'Lesson updated successfully!');
    }

    public function destroy(Course $course, CourseLesson $lesson)
    {
        $lesson->delete();

        return redirect()->route('admin.courses.lessons', $course)
            ->with('success', 'Lesson deleted successfully!');
    }
}
