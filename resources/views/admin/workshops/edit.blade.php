<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Workshop') }}
            </h2>
            <a href="{{ route('admin.workshops.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Workshops
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.workshops.update', $workshop) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Current Banner Preview -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Current Banner</label>
                            <img src="{{ $workshop->banner_url }}" alt="{{ $workshop->title }}" class="h-32 w-auto rounded-lg object-cover">
                        </div>

                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title *</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $workshop->title) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description *</label>
                            <textarea name="description" id="description" rows="4" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('description', $workshop->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Banner Image -->
                        <div>
                            <label for="banner_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">New Banner Image</label>
                            <input type="file" name="banner_image" id="banner_image" accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                            <p class="mt-1 text-xs text-gray-500">Leave empty to keep current image. Recommended size: 1200x400 pixels. Max 5MB.</p>
                            @error('banner_image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Instructor -->
                            <div>
                                <label for="instructor" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Instructor</label>
                                <input type="text" name="instructor" id="instructor" value="{{ old('instructor', $workshop->instructor) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>

                            <!-- Location -->
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Location</label>
                                <input type="text" name="location" id="location" value="{{ old('location', $workshop->location) }}" placeholder="e.g., Online, Lagos, Nairobi"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Start Date -->
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Date & Time *</label>
                                <input type="datetime-local" name="start_date" id="start_date" value="{{ old('start_date', $workshop->start_date->format('Y-m-d\TH:i')) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                @error('start_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- End Date -->
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Date & Time</label>
                                <input type="datetime-local" name="end_date" id="end_date" value="{{ old('end_date', $workshop->end_date?->format('Y-m-d\TH:i')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Price -->
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price (₦)</label>
                                <input type="number" name="price" id="price" value="{{ old('price', $workshop->price) }}" min="0" step="0.01"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>

                            <!-- Is Free -->
                            <div class="flex items-center pt-6">
                                <input type="checkbox" name="is_free" id="is_free" value="1" {{ old('is_free', $workshop->is_free) ? 'checked' : '' }}
                                    class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                <label for="is_free" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">This is a free workshop</label>
                            </div>

                            <!-- Max Participants -->
                            <div>
                                <label for="max_participants" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Max Participants</label>
                                <input type="number" name="max_participants" id="max_participants" value="{{ old('max_participants', $workshop->max_participants) }}" min="1"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    placeholder="Leave empty for unlimited">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Registration Link -->
                            <div>
                                <label for="registration_link" class="block text-sm font-medium text-gray-700 dark:text-gray-300">External Registration Link</label>
                                <input type="url" name="registration_link" id="registration_link" value="{{ old('registration_link', $workshop->registration_link) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    placeholder="https://...">
                            </div>

                            <!-- Sort Order -->
                            <div>
                                <label for="sort_order" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sort Order</label>
                                <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $workshop->sort_order) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                        </div>

                        <!-- Is Active -->
                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $workshop->is_active) ? 'checked' : '' }}
                                class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Active (visible on homepage)</label>
                        </div>

                        <div class="flex justify-end gap-4 pt-6 border-t">
                            <a href="{{ route('admin.workshops.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">Cancel</a>
                            <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 transition">Update Workshop</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
