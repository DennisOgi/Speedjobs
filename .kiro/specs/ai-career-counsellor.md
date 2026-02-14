# AI Career Counsellor - Powered by Gemini

## Executive Summary

Transform the existing manual career counselling system into an intelligent, AI-powered career guidance platform using Google's Gemini API. This feature will provide 24/7 personalized career advice, assessment analysis, and actionable recommendations to premium users.

---

## Current System Analysis

### Existing Features

**1. Career Counseling (Manual)**
- Users submit counseling requests with:
  - Request type (career_transition, interview_prep, etc.)
  - Message describing their situation
  - Preferred date/time
  - Status tracking (pending, assigned, completed, cancelled)
- Admin assigns human counselors
- Counselors have profiles with:
  - Specialization
  - Bio, experience, certifications
  - Hourly rate (₦15,000 - ₦20,000)
  - Availability schedules
  - Rating system

**2. Career Assessment**
- Four assessment types (UI only, not functional):
  - Personality Assessment (~15 min)
  - Skills Assessment (~20 min)
  - Interest Inventory (~10 min)
  - Aptitude Test (~30 min)
- Currently shows placeholder UI
- No results storage or analysis

**3. Career Planning Tool**
- Basic workbook interface
- No AI-powered pathway generation
- Minimal functionality

**4. Career Services Hub**
- Premium-only access
- Links to various career tools
- Resume builder integration
- Mentorship program

### Database Schema

**counseling_requests**
- user_id, request_type, message
- preferred_date, preferred_time
- status, assigned_counselor_id
- admin_notes

**counselors**
- user_id, specialization, bio
- years_of_experience, hourly_rate
- is_available, rating, total_sessions
- certifications (JSON)

**counselor_bookings**
- user_id, counselor_id, payment_id
- session_date, session_time, duration_minutes
- session_type (virtual/in-person)
- meeting_link, status
- feedback_rating, feedback_comment

### Pain Points

1. **Limited Availability**: Human counselors have scheduling constraints
2. **High Cost**: ₦15,000-20,000 per session limits accessibility
3. **Delayed Response**: Pending requests wait for admin assignment
4. **No Instant Guidance**: Users can't get immediate answers
5. **Assessment Gap**: Tests exist but provide no actionable insights
6. **Scalability**: Manual system doesn't scale with user growth

---

## Proposed Solution: AI Career Counsellor

### Vision

Create an intelligent AI counsellor that:
- Provides instant, 24/7 career guidance
- Analyzes user profiles, assessments, and career history
- Offers personalized recommendations
- Complements (not replaces) human counselors
- Scales infinitely with user base

### Core Features

#### 1. AI Chat Interface

**Conversational Career Guidance**
- Real-time chat with Gemini-powered AI counsellor
- Context-aware responses based on:
  - User profile (university, field of study, graduation year)
  - Skills and experience level
  - Previous conversations
  - Assessment results
  - Job applications history
  - Course enrollments

**Conversation Types**
- Career exploration ("What careers suit my skills?")
- Interview preparation ("How do I prepare for a tech interview?")
- Resume feedback ("Review my resume")
- Skill gap analysis ("What skills do I need for X role?")
- Career transition advice ("How do I switch from X to Y?")
- Salary negotiation tips
- Job search strategies

**Features**
- Conversation history storage
- Bookmarkable advice snippets
- Export conversations as PDF
- Follow-up question suggestions
- Multi-turn contextual dialogue

#### 2. Intelligent Assessment Analysis

**Automated Assessment Processing**
- Complete the 4 assessment types with real questions
- AI analyzes results using Gemini
- Generate comprehensive reports:
  - Personality profile with career matches
  - Skills matrix with strength/weakness analysis
  - Interest-based career recommendations
  - Aptitude scores with development areas

**Assessment Features**
- Adaptive questioning (difficulty adjusts based on responses)
- Visual result dashboards
- Career path suggestions based on results
- Skill development roadmaps
- Comparison with industry benchmarks

#### 3. AI Career Pathway Generator

**Personalized Career Roadmaps**
- Input: Current situation + Target role
- Output: Step-by-step action plan
  - Required skills to learn
  - Recommended courses (from platform)
  - Timeline with milestones
  - Job titles to target progressively
  - Networking strategies
  - Portfolio/project suggestions

**Dynamic Updates**
- Roadmap adjusts as user completes steps
- Celebrates milestones
- Suggests course corrections
- Tracks progress over time

#### 4. Resume & Application Analysis

**AI Resume Review**
- Upload resume for instant feedback
- Analysis includes:
  - ATS compatibility score
  - Keyword optimization
  - Structure and formatting
  - Content quality
  - Achievement quantification
  - Industry-specific suggestions
- Side-by-side comparison with job descriptions
- Generate improved versions

**Application Optimizer**
- Analyze job posting + user profile
- Suggest resume customizations
- Generate cover letter drafts
- Predict match percentage
- Highlight missing qualifications

#### 5. Interview Preparation Coach

**Mock Interview Practice**
- Role-specific interview questions
- AI evaluates responses
- Provides improvement feedback
- Tracks progress over multiple sessions
- Common mistake identification
- STAR method coaching

**Interview Strategies**
- Company research summaries
- Industry-specific tips
- Behavioral question frameworks
- Technical interview prep (for tech roles)
- Salary negotiation scripts

#### 6. Career Insights Dashboard

**Personalized Analytics**
- Career readiness score
- Skill gap visualization
- Market demand for user's skills
- Recommended next steps
- Progress tracking
- Goal achievement metrics

---

## Technical Architecture

### Technology Stack

**AI/ML**
- Google Gemini API (gemini-1.5-pro or gemini-1.5-flash)
- Laravel HTTP Client for API calls
- Streaming responses for real-time chat

**Backend**
- Laravel 12
- New Models: AiConversation, AiMessage, AssessmentResult, CareerPathway
- Queue jobs for long-running AI tasks
- Cache for frequently requested insights

**Frontend**
- Alpine.js for reactive chat interface
- Tailwind CSS for styling
- Real-time message streaming
- Markdown rendering for AI responses

**Storage**
- Database: Conversation history, assessments, pathways
- File storage: Resume uploads, generated reports
- Cache: AI response templates, common queries

### Database Schema Changes

**New Tables**

```sql
-- AI Conversations
ai_conversations
- id, user_id
- title (auto-generated from first message)
- conversation_type (career_advice, interview_prep, resume_review, etc.)
- context_data (JSON: user profile snapshot, relevant history)
- status (active, archived)
- last_message_at
- timestamps

-- AI Messages
ai_messages
- id, conversation_id
- role (user, assistant)
- content (text)
- metadata (JSON: tokens used, model version, processing time)
- created_at

-- Assessment Results
assessment_results
- id, user_id
- assessment_type (personality, skills, interest, aptitude)
- questions_data (JSON)
- answers_data (JSON)
- ai_analysis (text: Gemini's interpretation)
- scores (JSON: breakdown by category)
- recommendations (JSON: career matches, skills to develop)
- completed_at
- timestamps

-- Career Pathways
career_pathways
- id, user_id
- current_role, target_role
- pathway_data (JSON: steps, milestones, resources)
- progress_percentage
- status (active, completed, abandoned)
- ai_generated_at
- last_updated_at
- timestamps

-- AI Feedback
ai_feedback
- id, user_id, message_id
- rating (1-5)
- feedback_text
- is_helpful (boolean)
- created_at
```

### API Integration

**Gemini API Configuration**

```php
// config/services.php
'gemini' => [
    'api_key' => env('GEMINI_API_KEY'),
    'model' => env('GEMINI_MODEL', 'gemini-1.5-flash'),
    'max_tokens' => env('GEMINI_MAX_TOKENS', 2048),
    'temperature' => env('GEMINI_TEMPERATURE', 0.7),
],
```

**Service Class Structure**

```php
app/Services/GeminiService.php
- sendMessage($prompt, $context = [])
- streamMessage($prompt, $context = [])
- analyzeAssessment($assessmentData)
- generateCareerPathway($currentRole, $targetRole, $userProfile)
- reviewResume($resumeText, $jobDescription = null)
- generateInterviewQuestions($role, $experience)
```

### System Prompts

**Base Career Counsellor Prompt**
```
You are an expert career counsellor for SpeedJobs, a Nigerian job platform 
focused on university students and young professionals. Your role is to:

1. Provide personalized career guidance based on the Nigerian job market
2. Consider the user's educational background, skills, and career goals
3. Recommend relevant courses, jobs, and resources from the SpeedJobs platform
4. Be encouraging, professional, and culturally aware
5. Provide actionable, specific advice rather than generic responses
6. Reference Nigerian companies, industries, and career paths when relevant

User Context:
- Name: {name}
- University: {university}
- Field of Study: {field_of_study}
- Graduation Year: {graduation_year}
- Experience Level: {experience_level}
- Skills: {skills}
- Location: {location}

Previous conversation summary: {conversation_summary}

Respond in a friendly, professional tone. Keep responses concise but thorough.
```

**Assessment Analysis Prompt**
```
Analyze the following career assessment results and provide:

1. A comprehensive personality/skills/interest profile
2. Top 5 career paths that match this profile in the Nigerian market
3. Specific strengths to leverage
4. Areas for development with actionable steps
5. Recommended courses or certifications
6. Industry insights and job market trends

Assessment Type: {type}
Results: {results}

Format your response with clear sections and bullet points.
```

**Resume Review Prompt**
```
Review this resume and provide detailed feedback:

Resume Content:
{resume_text}

Target Job (if provided):
{job_description}

Provide:
1. Overall impression and ATS compatibility score (0-100)
2. Strengths (what's working well)
3. Weaknesses (what needs improvement)
4. Specific suggestions for each section
5. Keyword optimization recommendations
6. Formatting and structure advice
7. Achievement quantification opportunities

Be specific and actionable in your feedback.
```

---

## Implementation Plan

### Phase 1: Foundation (Week 1-2)

**Setup & Configuration**
- [ ] Add Gemini API credentials to .env
- [ ] Create GeminiService class
- [ ] Set up database migrations for new tables
- [ ] Create models: AiConversation, AiMessage, AssessmentResult, CareerPathway
- [ ] Build basic API integration with error handling

**Basic Chat Interface**
- [ ] Create chat UI component with Alpine.js
- [ ] Implement message sending/receiving
- [ ] Add conversation history display
- [ ] Create conversation management (new, archive, delete)
- [ ] Add loading states and error handling

### Phase 2: Core AI Features (Week 3-4)

**Conversational AI**
- [ ] Implement context-aware prompts
- [ ] Add user profile integration
- [ ] Build conversation history retrieval
- [ ] Create streaming response handler
- [ ] Add conversation summarization
- [ ] Implement follow-up suggestions

**Assessment System**
- [ ] Design assessment question banks
- [ ] Build assessment taking interface
- [ ] Implement AI analysis integration
- [ ] Create results visualization
- [ ] Generate PDF reports
- [ ] Store and retrieve past assessments

### Phase 3: Advanced Features (Week 5-6)

**Career Pathway Generator**
- [ ] Build pathway input form
- [ ] Implement AI pathway generation
- [ ] Create visual roadmap display
- [ ] Add progress tracking
- [ ] Integrate course recommendations
- [ ] Build milestone celebration system

**Resume Analysis**
- [ ] Create resume upload interface
- [ ] Implement text extraction (PDF/DOCX)
- [ ] Build AI review integration
- [ ] Design feedback display
- [ ] Add job description comparison
- [ ] Generate improvement suggestions

### Phase 4: Interview & Insights (Week 7-8)

**Interview Coach**
- [ ] Build mock interview interface
- [ ] Generate role-specific questions
- [ ] Implement response evaluation
- [ ] Create feedback system
- [ ] Add practice session history
- [ ] Build improvement tracking

**Dashboard & Analytics**
- [ ] Design career insights dashboard
- [ ] Implement readiness scoring
- [ ] Create skill gap visualization
- [ ] Add progress metrics
- [ ] Build recommendation engine
- [ ] Integrate all AI features

### Phase 5: Polish & Launch (Week 9-10)

**Quality & Performance**
- [ ] Optimize API calls and caching
- [ ] Implement rate limiting
- [ ] Add comprehensive error handling
- [ ] Build admin monitoring dashboard
- [ ] Create usage analytics
- [ ] Write documentation

**User Experience**
- [ ] Add onboarding tutorial
- [ ] Create help documentation
- [ ] Implement feedback collection
- [ ] Add export features (PDF, email)
- [ ] Build notification system
- [ ] Polish UI/UX

**Testing & Deployment**
- [ ] Unit tests for services
- [ ] Integration tests for AI flows
- [ ] User acceptance testing
- [ ] Performance testing
- [ ] Security audit
- [ ] Production deployment

---

## User Experience Flow

### First-Time User Journey

1. **Onboarding**
   - Welcome modal explaining AI counsellor
   - Quick profile completion prompt
   - Suggested first questions

2. **Initial Conversation**
   - AI introduces itself
   - Asks about career goals
   - Suggests taking assessments
   - Provides immediate value

3. **Assessment**
   - User takes personality/skills assessment
   - AI analyzes results
   - Generates personalized report
   - Recommends career paths

4. **Career Planning**
   - User selects target career
   - AI generates pathway
   - User explores recommended courses
   - Sets milestones

5. **Ongoing Support**
   - Regular check-ins
   - Progress tracking
   - Interview prep when applying
   - Resume reviews before applications

### Returning User Journey

1. **Dashboard View**
   - Career readiness score
   - Active pathway progress
   - Recent conversations
   - Recommended actions

2. **Quick Actions**
   - "Ask AI a question"
   - "Review my resume"
   - "Practice interview"
   - "Update my pathway"

3. **Contextual Help**
   - AI suggests help when user:
     - Views a job posting
     - Starts an application
     - Enrolls in a course
     - Completes a milestone

---

## Integration Points

### Existing Features

**Job Applications**
- AI suggests jobs matching user profile
- Provides application tips for specific jobs
- Analyzes job requirements vs user skills
- Generates customized cover letters

**Course Platform**
- AI recommends courses for skill gaps
- Tracks course completion in pathways
- Suggests next courses based on progress
- Provides learning tips

**Resume Builder**
- AI reviews resumes built in platform
- Suggests improvements in real-time
- Optimizes for specific job applications
- Generates content suggestions

**Human Counselors**
- AI handles initial queries
- Escalates complex cases to humans
- Provides conversation summary to counselors
- Complements human sessions with follow-up

---

## Cost & Resource Estimation

### API Costs (Gemini)

**Pricing (Gemini 1.5 Flash)**
- Input: $0.075 per 1M tokens
- Output: $0.30 per 1M tokens

**Estimated Usage per User/Month**
- 20 conversations × 500 tokens input = 10,000 tokens
- 20 conversations × 1,000 tokens output = 20,000 tokens
- 2 assessments × 2,000 tokens = 4,000 tokens
- 1 resume review × 3,000 tokens = 3,000 tokens
- **Total: ~37,000 tokens/user/month**

**Cost Calculation**
- 1,000 active users = 37M tokens/month
- Input: 37M × $0.075/1M = $2.78
- Output: 37M × $0.30/1M = $11.10
- **Total: ~$14/month for 1,000 users**
- **Per user: $0.014/month**

### Development Resources

**Team Requirements**
- 1 Backend Developer (Laravel/PHP)
- 1 Frontend Developer (Alpine.js/Tailwind)
- 1 AI/ML Engineer (Gemini integration)
- 1 UI/UX Designer
- 1 QA Engineer

**Timeline**
- 10 weeks for full implementation
- 2 weeks for testing and refinement
- **Total: 3 months to production**

---

## Success Metrics

### User Engagement
- Daily active users in AI chat
- Average conversations per user
- Conversation completion rate
- Return user rate

### Feature Adoption
- Assessment completion rate
- Career pathway creation rate
- Resume review usage
- Interview practice sessions

### Quality Metrics
- User satisfaction rating (1-5)
- Helpful response rate
- Human counselor escalation rate
- Feature request frequency

### Business Impact
- Premium conversion rate
- User retention improvement
- Support ticket reduction
- Platform engagement increase

---

## Risk Mitigation

### Technical Risks

**API Reliability**
- Implement fallback responses
- Cache common queries
- Queue non-urgent requests
- Monitor API health

**Cost Overruns**
- Set usage limits per user
- Implement rate limiting
- Cache aggressive responses
- Monitor spending daily

**Data Privacy**
- Encrypt sensitive data
- Anonymize training data
- Clear data retention policy
- GDPR compliance

### User Experience Risks

**AI Accuracy**
- Disclaimer about AI limitations
- Easy escalation to humans
- Feedback collection
- Regular prompt refinement

**User Trust**
- Transparent about AI usage
- Show confidence scores
- Provide sources/references
- Human review option

---

## Future Enhancements

### Phase 2 Features (Post-Launch)

1. **Voice Interface**
   - Voice input for questions
   - Audio responses
   - Interview practice with speech

2. **Multi-language Support**
   - Yoruba, Igbo, Hausa
   - Pidgin English
   - French (for West Africa)

3. **Industry-Specific Counselors**
   - Tech AI counselor
   - Finance AI counselor
   - Healthcare AI counselor
   - Creative industries AI counselor

4. **Peer Comparison**
   - Anonymous benchmarking
   - Industry standards comparison
   - Skill gap analysis vs peers

5. **Employer Integration**
   - Company-specific career paths
   - Direct employer Q&A
   - Hiring manager insights

6. **Mobile App**
   - Native iOS/Android apps
   - Push notifications
   - Offline mode

---

## Conclusion

The AI Career Counsellor will transform SpeedJobs from a job board into a comprehensive career development platform. By leveraging Gemini's capabilities, we can provide personalized, scalable, and affordable career guidance to thousands of Nigerian students and young professionals.

**Key Benefits:**
- 24/7 availability
- Instant responses
- Personalized advice
- Scalable solution
- Cost-effective (~$0.014/user/month)
- Complements human counselors

**Next Steps:**
1. Approve specification
2. Obtain Gemini API key
3. Assign development team
4. Begin Phase 1 implementation
5. Set up monitoring and analytics

---

**Document Version:** 1.0  
**Created:** February 5, 2026  
**Author:** AI Assistant  
**Status:** Draft - Awaiting Approval
