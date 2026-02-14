<x-app-layout>
<style>
    [x-cloak] { display: none !important; }
</style>
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-purple-50 py-12" x-data="sessionWizard()">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-600">Step {{ $session->current_step + 1 }} of {{ $session->total_steps }}</span>
                <span class="text-sm font-medium text-gray-600">{{ round(($session->current_step / max($session->total_steps, 1)) * 100) }}% complete</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="h-2.5 rounded-full transition-all duration-500
                    @if($session->module === 'career_assessment') bg-gradient-to-r from-blue-500 to-blue-600
                    @elseif($session->module === 'interview_prep') bg-gradient-to-r from-green-500 to-teal-600
                    @else bg-gradient-to-r from-purple-500 to-pink-600 @endif"
                    style="width: {{ ($session->current_step / max($session->total_steps, 1)) * 100 }}%"></div>
            </div>
        </div>

        <!-- Session Card -->
        <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">

            <!-- Module Header -->
            <div class="flex items-center gap-4 mb-8 pb-6 border-b border-gray-100">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center
                    @if($session->module === 'career_assessment') bg-blue-100 text-blue-600
                    @elseif($session->module === 'interview_prep') bg-green-100 text-green-600
                    @else bg-purple-100 text-purple-600 @endif">
                    @if($session->module === 'career_assessment')
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    @elseif($session->module === 'interview_prep')
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    @else
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    @endif
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ ucwords(str_replace('_', ' ', $session->module)) }}</h1>
                    @if($session->module === 'interview_prep' && isset($session->context_data['target_role']))
                        <p class="text-gray-500">Target Role: {{ $session->context_data['target_role'] }}</p>
                    @endif
                </div>
            </div>

            <!-- Step Content -->
            @if($stepData['type'] === 'choice')
                <form action="{{ route('ai-counselor.submit', $session) }}" method="POST">
                    @csrf
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">{{ $stepData['question'] }}</h2>
                    <div class="space-y-3 mb-8">
                        @foreach($stepData['options'] as $option)
                        <label class="flex items-center gap-4 p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-blue-400 hover:bg-blue-50/50 transition-all group has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                            <input type="radio" name="answer" value="{{ $option }}" class="w-5 h-5 text-blue-600 focus:ring-blue-500" required>
                            <span class="text-gray-700 group-hover:text-gray-900">{{ $option }}</span>
                        </label>
                        @endforeach
                    </div>
                    <button type="submit" class="w-full py-4 px-6 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg hover:shadow-xl">
                        Continue
                    </button>
                </form>

            @elseif($stepData['type'] === 'text')
                <form action="{{ route('ai-counselor.submit', $session) }}" method="POST">
                    @csrf
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">{{ $stepData['question'] }}</h2>
                    <textarea name="answer" rows="5" required
                        class="w-full p-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none mb-6"
                        placeholder="Type your answer here..."></textarea>
                    <button type="submit" class="w-full py-4 px-6 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg hover:shadow-xl">
                        Continue
                    </button>
                </form>

            @elseif($stepData['type'] === 'interview_answer')
                <div>
                    @if(isset($stepData['previous_feedback']))
                    <div class="mb-6 p-4 bg-green-50 rounded-xl border border-green-200">
                        <p class="text-sm font-medium text-green-800 mb-1">Feedback on your previous answer:</p>
                        <p class="text-green-700 text-sm">{{ $stepData['previous_feedback']['feedback'] ?? 'Good job!' }}</p>
                        @if(isset($stepData['previous_feedback']['score']))
                            <p class="text-green-600 text-sm mt-1">Score: {{ $stepData['previous_feedback']['score'] }}/10</p>
                        @endif
                    </div>
                    @endif
                    <form action="{{ route('ai-counselor.submit', $session) }}" method="POST">
                        @csrf
                        <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                            <span class="px-2 py-0.5 bg-gray-100 rounded text-xs font-medium uppercase">{{ $stepData['question_type'] ?? 'Behavioral' }}</span>
                            <span>Question {{ $stepData['question_number'] }} of 10</span>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-6">{{ $stepData['question'] }}</h2>
                        <textarea name="answer" rows="6" required minlength="20"
                            class="w-full p-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none mb-6"
                            placeholder="Take your time and provide a thoughtful answer..."></textarea>
                        <button type="submit" class="w-full py-4 px-6 bg-gradient-to-r from-green-600 to-teal-600 text-white font-semibold rounded-xl hover:from-green-700 hover:to-teal-700 transition-all shadow-lg hover:shadow-xl">
                            Submit Answer
                        </button>
                    </form>
                </div>

            @elseif($stepData['type'] === 'upload')
                <form action="{{ route('ai-counselor.submit', $session) }}" method="POST" enctype="multipart/form-data" 
                      x-data="{ fileName: '', uploading: false }"
                      @submit="uploading = true">
                    @csrf
                    
                    <!-- Loading Overlay -->
                    <div x-show="uploading" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
                        <div class="bg-white rounded-2xl p-8 max-w-md mx-4 text-center">
                            <div class="w-16 h-16 mx-auto mb-6 relative">
                                <div class="absolute inset-0 rounded-full border-4 border-gray-200"></div>
                                <div class="absolute inset-0 rounded-full border-4 border-t-purple-600 animate-spin"></div>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Analyzing Your Resume</h3>
                            <p class="text-gray-600 mb-4">Our AI is reviewing your resume and generating insights...</p>
                            <p class="text-sm text-gray-500">This may take 10-15 seconds. Please don't close this window.</p>
                        </div>
                    </div>
                    
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ $stepData['message'] }}</h2>
                    <p class="text-gray-600 mb-6">For best results, upload a PDF file. We'll analyze the content and provide detailed feedback.</p>
                    <div class="mb-6">
                        <label class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-gray-300 rounded-2xl cursor-pointer hover:border-purple-400 hover:bg-purple-50/50 transition-all"
                            @dragover.prevent="$el.classList.add('border-purple-500', 'bg-purple-50')"
                            @dragleave.prevent="$el.classList.remove('border-purple-500', 'bg-purple-50')"
                            @drop.prevent="fileName = $event.dataTransfer.files[0]?.name; $refs.fileInput.files = $event.dataTransfer.files">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-10 h-10 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <p class="mb-2 text-sm text-gray-500" x-show="!fileName">Drop your resume or <span class="text-purple-600 font-medium">click to browse</span></p>
                                <p class="text-sm text-gray-800 font-medium" x-show="fileName" x-text="fileName"></p>
                                <p class="text-xs text-gray-400">PDF, DOC, or DOCX (Max 5MB)</p>
                            </div>
                            <input type="file" name="resume" x-ref="fileInput" class="hidden" accept=".pdf,.doc,.docx" required
                                @change="fileName = $event.target.files[0]?.name">
                        </label>
                    </div>
                    <button type="submit" :disabled="!fileName || uploading" class="w-full py-4 px-6 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-semibold rounded-xl hover:from-purple-700 hover:to-pink-700 transition-all shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed">
                        <span x-show="!uploading">Upload & Analyze</span>
                        <span x-show="uploading">Uploading...</span>
                    </button>
                </form>

            @elseif(in_array($stepData['type'], ['generating', 'loading', 'analyzing']))
                <div class="text-center py-12">
                    <div class="w-16 h-16 mx-auto mb-6 relative">
                        <div class="absolute inset-0 rounded-full border-4 border-gray-200"></div>
                        <div class="absolute inset-0 rounded-full border-4 border-t-blue-600 animate-spin"></div>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $stepData['message'] }}</h2>
                    <p class="text-gray-500">This may take a moment. Please don't close this window.</p>
                </div>
            @endif

        </div>

        <!-- Back Link -->
        <div class="text-center mt-6">
            <a href="{{ route('ai-counselor.index') }}" class="text-sm text-gray-500 hover:text-gray-700">
                ← Back to AI Counselor
            </a>
        </div>

    </div>
</div>

<script>
function sessionWizard() {
    return {
        // Add any Alpine.js state if needed
    }
}
</script>
</x-app-layout>
