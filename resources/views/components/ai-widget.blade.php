@props(['context' => []])

<div 
    x-data="aiWidget()"
    x-init="initWidget()"
    class="fixed bottom-6 right-6 z-50 flex flex-col items-end"
    x-cloak
>
    <!-- Chat Window -->
    <div 
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        class="mb-4 w-[380px] max-w-[calc(100vw-3rem)] bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden flex flex-col"
        style="height: 600px; max-height: calc(100vh-8rem);"
    >
        <!-- Header -->
        <div class="p-4 bg-gradient-to-r from-blue-600 to-purple-600 flex items-center justify-between shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-white font-bold">AI Career Coach</h3>
                    <p class="text-white/80 text-xs flex items-center gap-1">
                        <span class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></span>
                        Online
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button 
                    @click="resetChat()"
                    class="p-2 hover:bg-white/10 rounded-lg transition-colors text-white/80 hover:text-white"
                    title="New Conversation"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </button>
                <button 
                    @click="isOpen = false"
                    class="p-2 hover:bg-white/10 rounded-lg transition-colors text-white/80 hover:text-white"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Messages Area -->
        <div 
            x-ref="messagesContainer"
            class="flex-1 overflow-y-auto p-4 space-y-4 bg-slate-50 scroll-smooth"
        >
            <template x-for="msg in messages" :key="msg.id">
                <div :class="msg.role === 'user' ? 'flex justify-end' : 'flex justify-start'">
                    <div 
                        :class="[
                            'max-w-[85%] rounded-2xl p-3 text-sm shadow-sm',
                            msg.role === 'user' 
                                ? 'bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-br-none' 
                                : 'bg-white border border-gray-100 text-gray-800 rounded-bl-none prose prose-sm max-w-none'
                        ]"
                    >
                        <div x-html="renderMarkdown(msg.content)"></div>
                    </div>
                </div>
            </template>
            
            <!-- Loading/Typing Indicator -->
            <div x-show="isTyping" class="flex justify-start" style="display: none;">
                <div class="bg-white border border-gray-100 rounded-2xl rounded-bl-none p-3 shadow-sm">
                    <div class="flex gap-1">
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></span>
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></span>
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="p-3 bg-white border-t border-gray-100 shrink-0">
            <form @submit.prevent="sendMessage" class="relative">
                <textarea 
                    x-model="input"
                    class="w-full pl-4 pr-12 py-3 bg-gray-50 border-transparent rounded-xl focus:bg-white focus:border-purple-500 focus:ring-0 resize-none text-sm max-h-32 transition-colors"
                    rows="1"
                    placeholder="Ask for career advice..."
                    @keydown.enter.prevent="if(!$event.shiftKey) sendMessage()"
                    :disabled="isTyping"
                ></textarea>
                <button 
                    type="submit"
                    class="absolute right-2 bottom-2 p-1.5 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg text-white shadow-sm hover:shadow-md disabled:opacity-50 disabled:cursor-not-allowed transition-all"
                    :disabled="!input.trim() || isTyping"
                >
                    <svg class="w-5 h-5 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </button>
            </form>
            <div class="text-center mt-2">
                 <p class="text-[10px] text-gray-400">AI can make mistakes. Verify important info.</p>
            </div>
        </div>
    </div>

    <!-- Toggle Button -->
    <button 
        @click="toggleChat()"
        class="group flex items-center gap-2 p-1 pl-4 pr-1 bg-white rounded-full shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300"
        :class="{'scale-0': isOpen}"
    >
        <span class="text-sm font-semibold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">AI Coach</span>
        <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-purple-600 rounded-full flex items-center justify-center group-hover:scale-105 transition-transform">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
            </svg>
        </div>
    </button>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
    function aiWidget() {
        return {
            isOpen: false,
            messages: [],
            input: '',
            isTyping: false,
            conversationId: null,
            initWidget() {
                // Restore state from localStorage if available
                const savedState = localStorage.getItem('ai_widget_state');
                if (savedState) {
                    const state = JSON.parse(savedState);
                    // this.isOpen = state.isOpen; // Don't auto-open on load, maybe annoying
                    this.messages = state.messages || [];
                    this.conversationId = state.conversationId;
                }
                
                // If no conversation, create one (or simulate welcome)
                if (this.messages.length === 0) {
                     this.messages.push({
                        id: Date.now(),
                        role: 'assistant',
                        content: "👋 Hi! I'm your AI Career Coach. How can I help you today?"
                    });
                }
                
                this.$watch('messages', () => this.scrollToBottom());
            },
            toggleChat() {
                this.isOpen = !this.isOpen;
                if (this.isOpen) {
                    this.$nextTick(() => this.scrollToBottom());
                    if (!this.conversationId) {
                         this.createConversation();
                    }
                }
                this.saveState();
            },
            saveState() {
                localStorage.setItem('ai_widget_state', JSON.stringify({
                    isOpen: this.isOpen,
                    messages: this.messages,
                    conversationId: this.conversationId,
                    timestamp: Date.now()
                }));
            },
            resetChat() {
                this.messages = [];
                this.conversationId = null;
                localStorage.removeItem('ai_widget_state');
                this.initWidget();
                this.createConversation();
            },
            async createConversation() {
                 try {
                    const response = await fetch('{{ route("ai-counselor.create") }}?type=general', {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    
                    if (!response.ok) throw new Error('Failed to create conversation');
                    
                    const data = await response.json();
                    this.conversationId = data.id;
                    
                    // If no local messages, use the server welcome message
                    if (this.messages.length === 0 && data.welcome_message) {
                        this.messages.push({
                            id: Date.now(),
                            role: 'assistant',
                            content: data.welcome_message
                        });
                    }
                    
                    this.saveState();
                    
                } catch (e) {
                    console.error("Failed to create conversation", e);
                }
            },
            async sendMessage() {
                if (!this.input.trim() || this.isTyping) return;
                
                const userMsg = this.input;
                this.input = '';
                
                // Add user message
                this.messages.push({
                    id: Date.now(),
                    role: 'user',
                    content: userMsg
                });
                
                this.isTyping = true;
                this.scrollToBottom();

                try {
                    // Ensure we have a conversation ID. If not, create one.
                    if (!this.conversationId) {
                        await this.createConversation();
                        if (!this.conversationId) throw new Error("Could not create conversation");
                    }

                    // Start Streaming
                    const response = await fetch(`/ai-counselor/${this.conversationId}/stream`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ message: userMsg })
                    });

                    if (!response.ok) {
                        if(response.status === 403) throw new Error("Upgrade to Premium");
                        throw new Error('Network response was not ok');
                    }

                    const reader = response.body.getReader();
                    const decoder = new TextDecoder();
                    let aiMsgId = Date.now() + 1;
                    
                    // Add empty AI message
                    this.messages.push({
                        id: aiMsgId,
                        role: 'assistant',
                        content: ''
                    });

                    let aiMessageContent = '';

                    while (true) {
                        const { done, value } = await reader.read();
                        if (done) break;
                        
                        const chunk = decoder.decode(value);
                        const lines = chunk.split('\n\n');
                        
                        for (const line of lines) {
                            if (line.startsWith('data: ')) {
                                try {
                                    const data = JSON.parse(line.slice(6));
                                    if (data.chunk) {
                                        aiMessageContent += data.chunk;
                                        // Update the last message
                                        this.messages[this.messages.length - 1].content = aiMessageContent;
                                        this.scrollToBottom();
                                    }
                                } catch (e) {
                                    // ignore parse errors for incomplete chunks
                                }
                            }
                        }
                    }

                } catch (error) {
                    console.error('Error:', error);
                    this.messages.push({
                        id: Date.now(),
                        role: 'assistant',
                        content: error.message === "Upgrade to Premium" 
                            ? "🔒 This is a premium feature. Please upgrade to chat with AI." 
                            : "Sorry, I encountered an error. Please try again."
                    });
                } finally {
                    this.isTyping = false;
                    this.saveState();
                }
            },
            scrollToBottom() {
                this.$nextTick(() => {
                    const container = this.$refs.messagesContainer;
                    container.scrollTop = container.scrollHeight;
                });
            },
            renderMarkdown(text) {
                return marked.parse(text);
            }
        }
    }
</script>
@endpush
</div>
