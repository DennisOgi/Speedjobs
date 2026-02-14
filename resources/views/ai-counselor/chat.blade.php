<x-app-layout>
    <div class="h-screen flex flex-col bg-gray-50" x-data="chatInterface()">
        
        <!-- Header -->
        <div class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('ai-counselor.index') }}" class="text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <div>
                    <h1 class="text-lg font-bold text-gray-900">{{ $conversation->title ?? 'AI Career Counselor' }}</h1>
                    <p class="text-sm text-gray-600">{{ ucfirst(str_replace('_', ' ', $conversation->conversation_type)) }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('ai-counselor.export', $conversation) }}" 
                   class="px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                    Export
                </a>
                <form action="{{ route('ai-counselor.destroy', $conversation) }}" method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this conversation?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 text-sm font-semibold text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <!-- Messages Container -->
        <div class="flex-1 overflow-y-auto px-6 py-6 space-y-6" x-ref="messagesContainer">
            @foreach($conversation->messages as $message)
                <div class="flex {{ $message->role === 'user' ? 'justify-end' : 'justify-start' }}">
                    <div class="flex gap-3 max-w-3xl {{ $message->role === 'user' ? 'flex-row-reverse' : '' }}">
                        <!-- Avatar -->
                        <div class="flex-shrink-0">
                            @if($message->role === 'user')
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            @else
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-500 to-teal-500 flex items-center justify-center text-white">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </div>

                        <!-- Message Content -->
                        <div class="flex-1">
                            <div class="rounded-2xl px-5 py-3 {{ $message->role === 'user' ? 'bg-gradient-to-r from-blue-600 to-purple-600 text-white' : 'bg-white border border-gray-200 text-gray-900' }}">
                                <div class="prose prose-sm max-w-none {{ $message->role === 'user' ? 'prose-invert' : '' }}">
                                    {!! \Illuminate\Support\Str::markdown($message->content) !!}
                                </div>
                            </div>
                            <div class="flex items-center gap-3 mt-2 text-xs text-gray-500 {{ $message->role === 'user' ? 'justify-end' : '' }}">
                                <span>{{ $message->created_at->diffForHumans() }}</span>
                                @if($message->role === 'assistant')
                                    <button @click="toggleFeedback({{ $message->id }})" class="hover:text-gray-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Loading indicator -->
            <div x-show="loading" class="flex justify-start">
                <div class="flex gap-3 max-w-3xl">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-500 to-teal-500 flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-2xl px-5 py-3">
                        <div class="flex gap-1">
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Suggestions -->
        <div x-show="suggestions.length > 0" class="px-6 py-3 bg-gray-50 border-t border-gray-200">
            <p class="text-xs text-gray-600 mb-2">Suggested questions:</p>
            <div class="flex flex-wrap gap-2">
                <template x-for="suggestion in suggestions" :key="suggestion">
                    <button @click="message = suggestion; sendMessage()" 
                            class="px-3 py-1.5 text-sm bg-white border border-gray-300 rounded-lg hover:border-blue-500 hover:text-blue-600 transition-colors"
                            x-text="suggestion"></button>
                </template>
            </div>
        </div>

        <!-- Input Area -->
        <div class="bg-white border-t border-gray-200 px-6 py-4">
            <form @submit.prevent="sendMessage" class="flex gap-3">
                <textarea 
                    x-model="message"
                    @keydown.enter.prevent="if(!$event.shiftKey) sendMessage()"
                    placeholder="Type your message... (Shift+Enter for new line)"
                    rows="1"
                    class="flex-1 resize-none rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-4 py-3"
                    :disabled="loading"
                    x-ref="messageInput"
                ></textarea>
                <button 
                    type="submit"
                    :disabled="loading || !message.trim()"
                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                    <span x-show="!loading">Send</span>
                    <span x-show="loading">Sending...</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </button>
            </form>
            <p class="text-xs text-gray-500 mt-2">AI-powered responses may take a few seconds. Press Shift+Enter for new line.</p>
        </div>

    </div>

    @push('scripts')
    <script>
        function chatInterface() {
            return {
                message: '',
                loading: false,
                suggestions: [],
                
                init() {
                    this.scrollToBottom();
                    this.$refs.messageInput.focus();
                },

                async sendMessage() {
                    if (!this.message.trim() || this.loading) return;

                    const userMessage = this.message;
                    this.message = '';
                    this.loading = true;
                    this.suggestions = [];

                    // Add user message to UI immediately
                    this.addMessageToUI('user', userMessage);

                    try {
                        const response = await fetch('{{ route('ai-counselor.send-message', $conversation) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({ message: userMessage })
                        });

                        const data = await response.json();

                        if (data.success) {
                            this.addMessageToUI('assistant', data.message.content);
                            this.suggestions = data.suggestions || [];
                        } else {
                            alert('Failed to send message. Please try again.');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    } finally {
                        this.loading = false;
                        this.$refs.messageInput.focus();
                    }
                },

                addMessageToUI(role, content) {
                    const container = this.$refs.messagesContainer;
                    const messageDiv = document.createElement('div');
                    messageDiv.className = `flex ${role === 'user' ? 'justify-end' : 'justify-start'}`;
                    
                    const isUser = role === 'user';
                    const avatar = isUser 
                        ? `<div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold">{{ substr(auth()->user()->name, 0, 1) }}</div>`
                        : `<div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-500 to-teal-500 flex items-center justify-center text-white"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg></div>`;
                    
                    messageDiv.innerHTML = `
                        <div class="flex gap-3 max-w-3xl ${isUser ? 'flex-row-reverse' : ''}">
                            <div class="flex-shrink-0">${avatar}</div>
                            <div class="flex-1">
                                <div class="rounded-2xl px-5 py-3 ${isUser ? 'bg-gradient-to-r from-blue-600 to-purple-600 text-white' : 'bg-white border border-gray-200 text-gray-900'}">
                                    <div class="prose prose-sm max-w-none ${isUser ? 'prose-invert' : ''}">${this.formatMarkdown(content)}</div>
                                </div>
                                <div class="flex items-center gap-3 mt-2 text-xs text-gray-500 ${isUser ? 'justify-end' : ''}">
                                    <span>Just now</span>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    container.appendChild(messageDiv);
                    this.scrollToBottom();
                },

                formatMarkdown(text) {
                    // Basic markdown formatting
                    return text
                        .replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>')
                        .replace(/\*(.+?)\*/g, '<em>$1</em>')
                        .replace(/\n/g, '<br>')
                        .replace(/^- (.+)$/gm, '<li>$1</li>')
                        .replace(/(<li>.*<\/li>)/s, '<ul>$1</ul>');
                },

                scrollToBottom() {
                    this.$nextTick(() => {
                        const container = this.$refs.messagesContainer;
                        container.scrollTop = container.scrollHeight;
                    });
                },

                toggleFeedback(messageId) {
                    // Implement feedback modal/form
                    alert('Feedback feature coming soon!');
                }
            }
        }
    </script>
    @endpush
</x-app-layout>
