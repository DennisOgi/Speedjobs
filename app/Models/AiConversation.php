<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AiConversation extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'conversation_type',
        'context_data',
        'status',
        'last_message_at',
    ];

    protected $casts = [
        'context_data' => 'array',
        'last_message_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(AiMessage::class, 'conversation_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('last_message_at', 'desc');
    }

    public function generateTitle(): void
    {
        if (!$this->title && $this->messages()->count() > 0) {
            $firstMessage = $this->messages()->where('role', 'user')->first();
            if ($firstMessage) {
                $this->title = \Illuminate\Support\Str::limit($firstMessage->content, 50);
                $this->save();
            }
        }
    }

    public function archive(): void
    {
        $this->update(['status' => 'archived']);
    }
}
