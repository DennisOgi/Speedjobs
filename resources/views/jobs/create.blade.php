<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-heading font-bold text-gray-900">Post a New Job</h1>
                <p class="text-gray-600 mt-1">Reach thousands of qualified candidates in Africa.</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <form action="{{ route('jobs.store') }}" method="POST" class="p-8 space-y-8">
                    @csrf

                    <!-- Job Details -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Job Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-2">
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Job Title</label>
                                <input type="text" name="title" id="title" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" placeholder="e.g. Senior Software Engineer" required>
                            </div>
                            
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                <select name="category" id="category" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" required>
                                    <option value="">Select a category</option>
                                    <option>Technology</option>
                                    <option>Finance</option>
                                    <option>Marketing</option>
                                    <option>Healthcare</option>
                                    <option>Education</option>
                                </select>
                            </div>

                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Job Type</label>
                                <select name="type" id="type" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" required>
                                    <option value="">Select type</option>
                                    <option>Full-time</option>
                                    <option>Part-time</option>
                                    <option>Contract</option>
                                    <option>Remote</option>
                                </select>
                            </div>

                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                                <input type="text" name="location" id="location" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" placeholder="e.g. Lagos, Nigeria" required>
                            </div>

                            <div>
                                <label for="salary_range" class="block text-sm font-medium text-gray-700 mb-1">Salary Range (Optional)</label>
                                <input type="text" name="salary_range" id="salary_range" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" placeholder="e.g. ₦200,000 - ₦400,000">
                                <p class="mt-1 text-xs text-gray-500">Enter salary range in Nigerian Naira (₦)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Description & Requirements</h3>
                        <div class="space-y-6">
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Job Description</label>
                                <textarea name="description" id="description" rows="6" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" placeholder="Describe the role and responsibilities..." required></textarea>
                            </div>

                            <div>
                                <label for="requirements" class="block text-sm font-medium text-gray-700 mb-1">Requirements</label>
                                <textarea name="requirements" id="requirements" rows="6" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" placeholder="List the skills and qualifications required..." required></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Company Info (Pre-filled if possible, but editable) -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Company Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-2">
                                <label for="company" class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                                <input type="text" name="company" id="company" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" placeholder="Your Company Name" required>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                        <a href="{{ route('employer.dashboard') }}" class="text-gray-600 hover:text-gray-900 font-medium">Cancel</a>
                        <button type="submit" class="px-6 py-3 bg-primary-600 text-white font-bold rounded-lg shadow hover:bg-primary-700 transition-colors">
                            Post Job
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
