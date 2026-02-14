<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-12" x-data="assessmentForm()">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Loading Overlay for Report Generation -->
            <div x-show="isGenerating" x-cloak class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center">
                <div class="bg-white rounded-2xl p-8 max-w-md mx-4 text-center shadow-2xl">
                    <div class="inline-block relative w-24 h-24 mb-6">
                        <div class="absolute top-0 left-0 w-full h-full border-4 border-gray-100 rounded-full"></div>
                        <div class="absolute top-0 left-0 w-full h-full border-4 border-blue-500 rounded-full border-t-transparent animate-spin"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-3xl">🧬</span>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Generating Your Career DNA Report</h3>
                    <p class="text-gray-600">Our AI is analyzing your responses to create a personalized career assessment...</p>
                    <div class="mt-4 flex items-center justify-center gap-1">
                        <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                        <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                        <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
                    </div>
                </div>
            </div>
            
            <!-- Header -->
            <div class="mb-8" x-show="!isGenerating">
                <a href="{{ route('assessments.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold mb-4 inline-block">
                    ← Back to Assessments
                </a>
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-500 rounded-xl flex items-center justify-center text-4xl">
                        {{ $assessmentInfo['icon'] }}
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold text-gray-900">{{ $assessmentInfo['title'] }}</h1>
                        <p class="text-lg text-gray-600">{{ $assessmentInfo['description'] }}</p>
                    </div>
                </div>
                
                <!-- Progress Bar -->
                <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-gray-700">Progress</span>
                        <span class="text-sm font-semibold text-gray-700" x-text="`${currentQuestion + 1} / {{ count($questions) }}`"></span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-gradient-to-r from-blue-600 to-purple-600 h-3 rounded-full transition-all duration-300" 
                             :style="`width: ${((currentQuestion + 1) / {{ count($questions) }}) * 100}%`"></div>
                    </div>
                </div>
            </div>

            <!-- Assessment Form -->
            <form action="{{ route('assessments.submit', $type) }}" method="POST" @submit="handleSubmit" x-show="!isGenerating">
                @csrf
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 mb-6">
                    @foreach($questions as $index => $question)
                        <div x-show="currentQuestion === {{ $index }}" x-transition class="space-y-6">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-6">
                                    Question {{ $index + 1 }} of {{ count($questions) }}
                                </h3>
                                <p class="text-lg text-gray-700 mb-6">{{ $question }}</p>
                            </div>

                            @if($type === 'personality')
                                <!-- Likert Scale for Personality -->
                                <div class="space-y-3">
                                    @foreach(['Strongly Disagree', 'Disagree', 'Neutral', 'Agree', 'Strongly Agree'] as $option)
                                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition-all">
                                            <input type="radio" name="answers[{{ $index }}]" value="{{ $option }}" required
                                                   class="w-5 h-5 text-blue-600 focus:ring-blue-500">
                                            <span class="ml-3 text-gray-900 font-medium">{{ $option }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @elseif($type === 'skills' || $type === 'interest')
                                <!-- Rating Scale -->
                                <div class="space-y-3">
                                    @foreach(['1 - Very Low', '2 - Low', '3 - Moderate', '4 - High', '5 - Very High'] as $option)
                                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition-all">
                                            <input type="radio" name="answers[{{ $index }}]" value="{{ $option }}" required
                                                   class="w-5 h-5 text-blue-600 focus:ring-blue-500">
                                            <span class="ml-3 text-gray-900 font-medium">{{ $option }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @else
                                <!-- Text Input for Aptitude -->
                                <input type="text" name="answers[{{ $index }}]" required
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                                       placeholder="Enter your answer">
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between items-center">
                    <button type="button" @click="previousQuestion" x-show="currentQuestion > 0"
                            class="px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-colors">
                        ← Previous
                    </button>
                    
                    <div class="flex gap-3">
                        <button type="button" @click="nextQuestion" x-show="currentQuestion < {{ count($questions) - 1 }}"
                                class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                            Next →
                        </button>
                        
                        <button type="submit" x-show="currentQuestion === {{ count($questions) - 1 }}"
                                class="px-8 py-3 bg-gradient-to-r from-green-600 to-teal-600 text-white font-semibold rounded-lg hover:from-green-700 hover:to-teal-700 transition-all">
                            Submit Assessment
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <script>
        function assessmentForm() {
            return {
                currentQuestion: 0,
                totalQuestions: {{ count($questions) }},
                isGenerating: false,
                
                nextQuestion() {
                    if (this.currentQuestion < this.totalQuestions - 1) {
                        this.currentQuestion++;
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                },
                
                previousQuestion() {
                    if (this.currentQuestion > 0) {
                        this.currentQuestion--;
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                },
                
                handleSubmit(e) {
                    if (!confirm('Are you sure you want to submit this assessment? You can retake it later if needed.')) {
                        e.preventDefault();
                        return false;
                    }
                    // Show loading indicator
                    this.isGenerating = true;
                    // Form will submit normally
                }
            }
        }
    </script>
</x-app-layout>
