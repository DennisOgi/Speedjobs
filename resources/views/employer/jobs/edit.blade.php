<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-heading font-bold text-gray-900">Edit Job</h1>
                    <p class="text-gray-600 mt-1">Update your job posting details.</p>
                </div>
                <a href="{{ route('employer.jobs.index') }}" class="text-sm text-primary-600 hover:text-primary-700 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Jobs
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <form action="{{ route('employer.jobs.update', $job) }}" method="POST" class="p-8 space-y-8">
                    @csrf
                    @method('PUT')

                    <!-- Job Details -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Job Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-2">
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Job Title</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $job->title) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" required>
                                @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                <select name="category" id="category" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" required>
                                    <option value="">Select a category</option>
                                    @foreach(['Technology', 'Finance', 'Marketing', 'Healthcare', 'Education', 'Engineering', 'Sales', 'Human Resources', 'Other'] as $cat)
                                        <option value="{{ $cat }}" {{ old('category', $job->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                    @endforeach
                                </select>
                                @error('category')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Job Type</label>
                                <select name="type" id="type" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" required>
                                    <option value="">Select type</option>
                                    @foreach(['Full-time', 'Part-time', 'Contract', 'Remote', 'Internship', 'Freelance'] as $type)
                                        <option value="{{ $type }}" {{ old('type', $job->type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                                @error('type')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                                <input type="text" name="location" id="location" value="{{ old('location', $job->location) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" required>
                                @error('location')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="salary_range" class="block text-sm font-medium text-gray-700 mb-1">Salary Range</label>
                                <input type="text" name="salary_range" id="salary_range" value="{{ old('salary_range', $job->salary_range) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" placeholder="e.g. ₦200,000 - ₦400,000">
                                <p class="mt-1 text-xs text-gray-500">Enter salary range in Nigerian Naira (₦)</p>
                                @error('salary_range')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Description & Requirements</h3>
                        <div class="space-y-6">
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Job Description</label>
                                <textarea name="description" id="description" rows="6" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" required>{{ old('description', $job->description) }}</textarea>
                                @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="requirements" class="block text-sm font-medium text-gray-700 mb-1">Requirements</label>
                                <textarea name="requirements" id="requirements" rows="6" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ old('requirements', $job->requirements) }}</textarea>
                                @error('requirements')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- Company Info -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Company Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-2">
                                <label for="company" class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                                <input type="text" name="company" id="company" value="{{ old('company', $job->company) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" required>
                                @error('company')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                        <form action="{{ route('employer.jobs.destroy', $job) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this job? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-700 font-medium">Delete Job</button>
                        </form>
                        <div class="flex gap-4">
                            <a href="{{ route('employer.jobs.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">Cancel</a>
                            <button type="submit" class="px-6 py-3 bg-primary-600 text-white font-bold rounded-lg shadow hover:bg-primary-700 transition-colors">
                                Update Job
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
