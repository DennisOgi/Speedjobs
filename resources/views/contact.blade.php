<x-app-layout>
    <div class="bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50 min-h-screen">
        <!-- Hero Section -->
        <div class="relative py-24 sm:py-32 overflow-hidden isolate">
            <!-- Background Image -->
            <img src="https://images.unsplash.com/photo-1423666639041-f56000c27a9a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="" class="absolute inset-0 -z-10 h-full w-full object-cover">
            
            <!-- Gradient Overlay -->
            <div class="absolute inset-0 -z-10 bg-gradient-to-b from-gray-900/80 via-gray-900/60 to-gray-900/80"></div>

            <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
                <div class="text-center">
                    <div class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 mb-6">
                        <svg class="w-4 h-4 text-primary-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-sm font-semibold text-white">We're Here to Help</span>
                    </div>
                    <h1 class="text-5xl font-extrabold tracking-tight text-white sm:text-6xl mb-6 drop-shadow-sm">
                        Contact <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-200 to-accent-200">Us</span>
                    </h1>
                    <p class="text-xl text-gray-200 max-w-3xl mx-auto leading-relaxed drop-shadow-sm">
                        Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.
                    </p>
                </div>
            </div>
        </div>

        <!-- Contact Section -->
        <div class="py-24 sm:py-32 relative">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
                    
                    <!-- Contact Form -->
                    <div class="bg-white rounded-3xl p-10 shadow-xl border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Send us a Message</h2>
                        <p class="text-gray-600 mb-8">Fill out the form below and we'll get back to you within 24 hours.</p>
                        
                        @if(session('success'))
                            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 font-medium">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                            @csrf
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Full Name</label>
                                    <input type="text" name="name" id="name" required value="{{ old('name', auth()->user()->name ?? '') }}"
                                        class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white shadow-sm focus:border-primary-500 focus:ring-primary-500 transition-all"
                                        placeholder="John Doe">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                                    <input type="email" name="email" id="email" required value="{{ old('email', auth()->user()->email ?? '') }}"
                                        class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white shadow-sm focus:border-primary-500 focus:ring-primary-500 transition-all"
                                        placeholder="john@example.com">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div>
                                <label for="phone" class="block text-sm font-bold text-gray-700 mb-2">Phone Number (Optional)</label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}"
                                    class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white shadow-sm focus:border-primary-500 focus:ring-primary-500 transition-all"
                                    placeholder="+234 800 000 0000">
                            </div>
                            
                            <div>
                                <label for="subject" class="block text-sm font-bold text-gray-700 mb-2">Subject</label>
                                <select name="subject" id="subject" required
                                    class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white shadow-sm focus:border-primary-500 focus:ring-primary-500 transition-all">
                                    <option value="">Select a topic</option>
                                    <option value="general" {{ old('subject') == 'general' ? 'selected' : '' }}>General Inquiry</option>
                                    <option value="support" {{ old('subject') == 'support' ? 'selected' : '' }}>Technical Support</option>
                                    <option value="billing" {{ old('subject') == 'billing' ? 'selected' : '' }}>Billing & Payments</option>
                                    <option value="partnership" {{ old('subject') == 'partnership' ? 'selected' : '' }}>Partnership Opportunities</option>
                                    <option value="feedback" {{ old('subject') == 'feedback' ? 'selected' : '' }}>Feedback & Suggestions</option>
                                    <option value="employer" {{ old('subject') == 'employer' ? 'selected' : '' }}>Employer Services</option>
                                </select>
                                @error('subject')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="message" class="block text-sm font-bold text-gray-700 mb-2">Message</label>
                                <textarea name="message" id="message" rows="5" required
                                    class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white shadow-sm focus:border-primary-500 focus:ring-primary-500 transition-all resize-none"
                                    placeholder="How can we help you?">{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <button type="submit" class="w-full py-4 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Send Message
                            </button>
                        </form>
                    </div>

                    <!-- Contact Info & FAQ -->
                    <div class="space-y-8">
                        <!-- Contact Cards -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Email -->
                            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all group">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white mb-4 group-hover:scale-110 transition-transform">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="font-bold text-gray-900 mb-1">Email Us</h3>
                                <p class="text-gray-600 text-sm mb-3">We'll respond within 24 hours</p>
                                <a href="mailto:{{ __('content.brand.email') }}" class="text-primary-600 font-medium hover:text-primary-700 transition-colors">
                                    {{ __('content.brand.email') }}
                                </a>
                            </div>

                            <!-- Phone -->
                            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all group">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center text-white mb-4 group-hover:scale-110 transition-transform">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <h3 class="font-bold text-gray-900 mb-1">Call Us</h3>
                                <p class="text-gray-600 text-sm mb-3">Mon-Fri from 8am to 6pm</p>
                                <a href="tel:{{ __('content.brand.phone') }}" class="text-primary-600 font-medium hover:text-primary-700 transition-colors">
                                    {{ __('content.brand.phone') }}
                                </a>
                            </div>

                            <!-- WhatsApp -->
                            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all group">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center text-white mb-4 group-hover:scale-110 transition-transform">
                                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                </div>
                                <h3 class="font-bold text-gray-900 mb-1">WhatsApp</h3>
                                <p class="text-gray-600 text-sm mb-3">Quick responses via chat</p>
                                <a href="https://wa.me/2348036176229" target="_blank" class="text-primary-600 font-medium hover:text-primary-700 transition-colors">
                                    Chat with us
                                </a>
                            </div>

                            <!-- Office -->
                            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all group">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center text-white mb-4 group-hover:scale-110 transition-transform">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="font-bold text-gray-900 mb-1">Visit Us</h3>
                                <p class="text-gray-600 text-sm mb-3">Our office location</p>
                                <p class="text-gray-700 text-sm">Lagos, Nigeria</p>
                            </div>
                        </div>

                        <!-- FAQ Section -->
                        <div class="bg-white rounded-3xl p-8 shadow-xl border border-gray-100">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">Frequently Asked Questions</h2>
                            
                            <div class="space-y-4" x-data="{ openFaq: null }">
                                <!-- FAQ Item 1 -->
                                <div class="border border-gray-100 rounded-xl overflow-hidden">
                                    <button @click="openFaq = openFaq === 1 ? null : 1" class="w-full flex items-center justify-between p-4 text-left hover:bg-gray-50 transition-colors">
                                        <span class="font-medium text-gray-900">How do I create an account?</span>
                                        <svg class="w-5 h-5 text-gray-500 transition-transform" :class="{ 'rotate-180': openFaq === 1 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div x-show="openFaq === 1" x-collapse class="px-4 pb-4 text-gray-600 text-sm">
                                        Click the "Get Started" button in the top navigation, fill in your details, and verify your email address. It only takes a minute!
                                    </div>
                                </div>

                                <!-- FAQ Item 2 -->
                                <div class="border border-gray-100 rounded-xl overflow-hidden">
                                    <button @click="openFaq = openFaq === 2 ? null : 2" class="w-full flex items-center justify-between p-4 text-left hover:bg-gray-50 transition-colors">
                                        <span class="font-medium text-gray-900">Is SpeedJobs free to use?</span>
                                        <svg class="w-5 h-5 text-gray-500 transition-transform" :class="{ 'rotate-180': openFaq === 2 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div x-show="openFaq === 2" x-collapse class="px-4 pb-4 text-gray-600 text-sm">
                                        Yes! Basic job searching and applications are completely free. We offer premium features like career counseling and advanced courses for paid members.
                                    </div>
                                </div>

                                <!-- FAQ Item 3 -->
                                <div class="border border-gray-100 rounded-xl overflow-hidden">
                                    <button @click="openFaq = openFaq === 3 ? null : 3" class="w-full flex items-center justify-between p-4 text-left hover:bg-gray-50 transition-colors">
                                        <span class="font-medium text-gray-900">How do I apply for a job?</span>
                                        <svg class="w-5 h-5 text-gray-500 transition-transform" :class="{ 'rotate-180': openFaq === 3 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div x-show="openFaq === 3" x-collapse class="px-4 pb-4 text-gray-600 text-sm">
                                        Browse our job listings, click on a job you're interested in, and click the "Apply Now" button. Make sure your profile is complete for the best results.
                                    </div>
                                </div>

                                <!-- FAQ Item 4 -->
                                <div class="border border-gray-100 rounded-xl overflow-hidden">
                                    <button @click="openFaq = openFaq === 4 ? null : 4" class="w-full flex items-center justify-between p-4 text-left hover:bg-gray-50 transition-colors">
                                        <span class="font-medium text-gray-900">How can employers post jobs?</span>
                                        <svg class="w-5 h-5 text-gray-500 transition-transform" :class="{ 'rotate-180': openFaq === 4 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div x-show="openFaq === 4" x-collapse class="px-4 pb-4 text-gray-600 text-sm">
                                        Register as an employer, complete your company profile, and navigate to "Post a Job" from your dashboard. Our team reviews all postings within 24 hours.
                                    </div>
                                </div>

                                <!-- FAQ Item 5 -->
                                <div class="border border-gray-100 rounded-xl overflow-hidden">
                                    <button @click="openFaq = openFaq === 5 ? null : 5" class="w-full flex items-center justify-between p-4 text-left hover:bg-gray-50 transition-colors">
                                        <span class="font-medium text-gray-900">What is the premium membership?</span>
                                        <svg class="w-5 h-5 text-gray-500 transition-transform" :class="{ 'rotate-180': openFaq === 5 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div x-show="openFaq === 5" x-collapse class="px-4 pb-4 text-gray-600 text-sm">
                                        Premium members get access to career counseling, exclusive courses, career planning workbooks, priority support, and advanced job matching features.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
