# 🤖 AI Career Counselor - Setup Guide

## Overview

The AI Career Counselor is a sophisticated, AI-powered career guidance system integrated into SpeedJobs. It provides 24/7 personalized career advice, assessment analysis, resume reviews, interview preparation, and career pathway planning using Google's Gemini API.

## Features Implemented

### ✅ Phase 1: Core Infrastructure (COMPLETE)

1. **Database Schema**
   - `ai_conversations` - Stores conversation threads
   - `ai_messages` - Individual messages in conversations
   - `assessment_results` - Career assessment data and AI analysis
   - `career_pathways` - Personalized career roadmaps
   - `ai_feedback` - User feedback on AI responses

2. **Models & Relationships**
   - `AiConversation` - Conversation management
   - `AiMessage` - Message handling
   - `AssessmentResult` - Assessment storage
   - `CareerPathway` - Pathway tracking
   - `AiFeedback` - Feedback collection
   - Updated `User` model with AI relationships

3. **Gemini Service**
   - Full API integration with Google Gemini
   - Context-aware prompts
   - Conversation history management
   - Assessment analysis
   - Career pathway generation
   - Resume review
   - Interview question generation
   - Error handling and fallbacks

4. **Controllers & Routes**
   - `AiCounselorController` - Main controller
   - RESTful routes for all operations
   - Policy-based authorization
   - Premium user access control

5. **User Interface**
   - Beautiful dashboard with stats
   - Real-time chat interface
   - Conversation management
   - Quick action buttons
   - Responsive design
   - Alpine.js for interactivity

## Setup Instructions

### 1. Get Your Gemini API Key

1. Visit https://aistudio.google.com/app/apikey
2. Sign in with your Google account
3. Click "Create API Key"
4. Copy the generated key

### 2. Configure Environment

Add to your `.env` file:

```env
GEMINI_API_KEY=your_api_key_here
GEMINI_MODEL=gemini-1.5-flash
GEMINI_MAX_TOKENS=2048
GEMINI_TEMPERATURE=0.7
```

### 3. Run Migrations

```bash
php artisan migrate
```

This will create all necessary database tables.

### 4. Test the Feature

1. Log in as a premium user (set `is_paid = 1` in users table)
2. Navigate to `/career-services`
3. Click on "AI Career Counselor"
4. Start a conversation!

## Usage Guide

### For Users

**Starting a Conversation:**
1. Go to Career Services → AI Career Counselor
2. Choose a conversation type:
   - Career Advice - General career guidance
   - Interview Prep - Practice interviews
   - Resume Review - Get resume feedback
   - Assessment - Take career assessments
   - Career Path - Create roadmaps

**Chatting:**
- Type your question in the input box
- Press Enter to send (Shift+Enter for new line)
- AI responds in real-time
- Click suggested questions for quick follow-ups

**Managing Conversations:**
- Archive old conversations
- Export conversations as text files
- Delete conversations you no longer need
- View conversation history

### For Developers

**Adding New Conversation Types:**

1. Update the welcome message in `AiCounselorController::getWelcomeMessage()`
2. Add the type to the quick actions in `ai-counselor/index.blade.php`
3. Optionally create specialized prompts in `GeminiService`

**Customizing AI Behavior:**

Edit `GeminiService::buildSystemPrompt()` to modify:
- AI personality
- Response style
- Context awareness
- Industry focus

**Adding New AI Features:**

1. Create method in `GeminiService`
2. Add controller action in `AiCounselorController`
3. Create route in `routes/web.php`
4. Build UI component

## API Cost Management

**Current Configuration:**
- Model: `gemini-1.5-flash` (cost-effective)
- Max tokens: 2048 per response
- Temperature: 0.7 (balanced creativity)

**Estimated Costs:**
- ~$0.014 per user per month
- ~$14 for 1,000 active users per month

**Cost Optimization Tips:**
1. Use caching for common queries
2. Implement rate limiting
3. Set conversation history limits
4. Monitor usage via logs

## Security & Privacy

**Implemented:**
- Policy-based authorization
- Premium-only access
- User data isolation
- CSRF protection
- Input validation

**Best Practices:**
- Never log API keys
- Encrypt sensitive data
- Clear old conversations periodically
- Monitor for abuse

## Troubleshooting

### "Failed to get response from Gemini API"

**Causes:**
- Invalid API key
- API quota exceeded
- Network issues
- Invalid request format

**Solutions:**
1. Verify API key in `.env`
2. Check API quota at https://aistudio.google.com
3. Review logs: `storage/logs/laravel.log`
4. Test API key with curl:

```bash
curl "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=YOUR_API_KEY" \
  -H 'Content-Type: application/json' \
  -d '{"contents":[{"parts":[{"text":"Hello"}]}]}'
```

### Messages Not Appearing

**Check:**
1. JavaScript console for errors
2. Network tab for failed requests
3. CSRF token validity
4. User authentication status

### Slow Responses

**Optimize:**
1. Reduce max_tokens
2. Limit conversation history
3. Use faster model (gemini-1.5-flash)
4. Implement caching

## Next Steps

### Phase 2: Assessment System
- [ ] Build assessment question banks
- [ ] Create assessment taking interface
- [ ] Implement AI analysis
- [ ] Generate PDF reports

### Phase 3: Advanced Features
- [ ] Career pathway generator UI
- [ ] Resume upload and parsing
- [ ] Interview practice mode
- [ ] Voice input/output

### Phase 4: Analytics
- [ ] Usage dashboard
- [ ] Cost tracking
- [ ] User satisfaction metrics
- [ ] Popular topics analysis

## Support

**Documentation:**
- Gemini API: https://ai.google.dev/docs
- Laravel: https://laravel.com/docs
- Alpine.js: https://alpinejs.dev

**Need Help?**
- Check logs: `storage/logs/laravel.log`
- Review specs: `.kiro/specs/ai-career-counsellor.md`
- Test API directly: https://aistudio.google.com

## Credits

**Built with:**
- Laravel 12
- Google Gemini AI
- Alpine.js
- Tailwind CSS

**Developed:** February 2026
**Version:** 1.0.0

---

**Ready to impress your users with AI-powered career guidance! 🚀**
