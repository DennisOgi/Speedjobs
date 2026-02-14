<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseCategoryController extends Controller
{
    public function index()
    {
        $categories = CourseCategory::withCount('courses')
            ->orderBy('order')
            ->get();

        return view('admin.course-categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:course_categories,slug',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['order'] = $validated['order'] ?? CourseCategory::max('order') + 1;

        CourseCategory::create($validated);

        return redirect()->route('admin.course-categories.index')
            ->with('success', 'Category created successfully!');
    }

    public function update(Request $request, CourseCategory $courseCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:course_categories,slug,' . $courseCategory->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);

        $courseCategory->update($validated);

        return redirect()->route('admin.course-categories.index')
            ->with('success', 'Category updated successfully!');
    }

    public function destroy(CourseCategory $courseCategory)
    {
        if ($courseCategory->courses()->count() > 0) {
            return redirect()->route('admin.course-categories.index')
                ->with('error', 'Cannot delete category with courses. Please reassign or delete courses first.');
        }

        $courseCategory->delete();

        return redirect()->route('admin.course-categories.index')
            ->with('success', 'Category deleted successfully!');
    }
}
