<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Resume Analysis</h1>
                <p class="text-lg text-gray-600">Get AI-powered feedback to optimize your resume for ATS systems</p>
            </div>

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-800">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                        <p class="font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-800">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <p class="font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total Analyses</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['total_analyses'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <span class="text-2xl">📄</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Average ATS Score</p>
                            <p class="text-3xl font-bold text-blue-600">{{ round($stats['average_score']) }}%</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <span class="text-2xl">📊</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upload Form -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Upload Resume for Analysis</h2>
                
                <form action="{{ route('resume-analysis.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Resume File *</label>
                        <input type="file" name="resume_file" accept=".pdf,.doc,.docx,.txt" required
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
                        <p class="text-sm text-gray-600 mt-2">
                            <strong>Supported formats:</strong> PDF, DOCX, TXT (Max 5MB)<br>
                            <strong>⚠️ Important:</strong> PDFs must have selectable text (not scanned images). If you get an error, try saving your resume as DOCX or TXT format instead.
                        </p>
                        @error('resume_file')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Job Description (Optional)</label>
                        <textarea name="job_description" rows="6" 
                                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                                  placeholder="Paste the job description here to get tailored feedback..."></textarea>
                        <p class="text-sm text-gray-600 mt-2">Adding a job description helps us provide more specific recommendations</p>
                        @error('job_description')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" 
                            class="w-full px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl">
                        Analyze Resume with AI
                    </button>
                </form>
            </div>

            <!-- Previous Analyses -->
            @if($analyses->count() > 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Previous Analyses</h2>
                    
                    <div class="space-y-4">
                        @foreach($analyses as $analysis)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex items-center gap-4 flex-1">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-500 rounded-lg flex items-center justify-center text-white font-bold text-xl">
                                        {{ $analysis->ats_score }}
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900">{{ $analysis->file_name }}</h4>
                                        <p class="text-sm text-gray-600">Analyzed {{ $analysis->analyzed_at->diffForHumans() }}</p>
                                        @if($analysis->job_description)
                                            <p class="text-xs text-blue-600 mt-1">✓ Matched against job description</p>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-3">
                                    <div class="text-right">
                                        <p class="text-sm text-gray-600">ATS Score</p>
                                        <p class="text-2xl font-bold {{ $analysis->ats_score >= 80 ? 'text-green-600' : ($analysis->ats_score >= 60 ? 'text-yellow-600' : 'text-red-600') }}">
                                            {{ $analysis->ats_score }}%
                                        </p>
                                    </div>
                                    <a href="{{ route('resume-analysis.show', $analysis) }}" 
                                       class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $analyses->links() }}
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
