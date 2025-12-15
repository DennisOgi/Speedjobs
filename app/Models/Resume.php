<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resume extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'template',
        'color_scheme',
        'photo',
        'full_name',
        'job_title',
        'email',
        'phone',
        'location',
        'website',
        'linkedin',
        'github',
        'summary',
        'experience',
        'education',
        'skills',
        'languages',
        'certifications',
        'projects',
        'awards',
        'references',
        'section_order',
        'visible_sections',
        'is_primary',
        'last_edited_at',
    ];

    protected $casts = [
        'experience' => 'array',
        'education' => 'array',
        'skills' => 'array',
        'languages' => 'array',
        'certifications' => 'array',
        'projects' => 'array',
        'awards' => 'array',
        'references' => 'array',
        'section_order' => 'array',
        'visible_sections' => 'array',
        'is_primary' => 'boolean',
        'last_edited_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        return '';
    }

    public static function getDefaultSectionOrder(): array
    {
        return [
            'summary',
            'experience',
            'education',
            'skills',
            'projects',
            'certifications',
            'languages',
            'awards',
            'references',
        ];
    }

    public static function getDefaultVisibleSections(): array
    {
        return [
            'summary' => true,
            'experience' => true,
            'education' => true,
            'skills' => true,
            'projects' => false,
            'certifications' => false,
            'languages' => false,
            'awards' => false,
            'references' => false,
        ];
    }

    public static function getAvailableTemplates(): array
    {
        return [
            'professional' => [
                'name' => 'Professional',
                'description' => 'Clean and traditional design perfect for corporate roles',
                'preview' => '/images/templates/professional.png',
            ],
            'modern' => [
                'name' => 'Modern',
                'description' => 'Contemporary layout with sidebar and timeline',
                'preview' => '/images/templates/modern.png',
            ],
            'executive' => [
                'name' => 'Executive',
                'description' => 'Elegant serif design for senior positions',
                'preview' => '/images/templates/executive.png',
            ],
            'minimal' => [
                'name' => 'Minimal',
                'description' => 'Simple and clean with focus on content',
                'preview' => '/images/templates/minimal.png',
            ],
            'creative' => [
                'name' => 'Creative',
                'description' => 'Bold design for creative industries',
                'preview' => '/images/templates/creative.png',
            ],
            'tech' => [
                'name' => 'Tech',
                'description' => 'Developer-focused with code-inspired elements',
                'preview' => '/images/templates/tech.png',
            ],
            'elegant' => [
                'name' => 'Elegant',
                'description' => 'Sophisticated design with refined typography',
                'preview' => '/images/templates/elegant.png',
            ],
            'bold' => [
                'name' => 'Bold',
                'description' => 'High-impact design that stands out',
                'preview' => '/images/templates/bold.png',
            ],
        ];
    }

    public static function getColorSchemes(): array
    {
        return [
            'blue' => ['primary' => '#2563eb', 'secondary' => '#1e40af', 'accent' => '#3b82f6'],
            'emerald' => ['primary' => '#059669', 'secondary' => '#047857', 'accent' => '#10b981'],
            'purple' => ['primary' => '#7c3aed', 'secondary' => '#6d28d9', 'accent' => '#8b5cf6'],
            'rose' => ['primary' => '#e11d48', 'secondary' => '#be123c', 'accent' => '#f43f5e'],
            'amber' => ['primary' => '#d97706', 'secondary' => '#b45309', 'accent' => '#f59e0b'],
            'slate' => ['primary' => '#475569', 'secondary' => '#334155', 'accent' => '#64748b'],
            'teal' => ['primary' => '#0d9488', 'secondary' => '#0f766e', 'accent' => '#14b8a6'],
            'indigo' => ['primary' => '#4f46e5', 'secondary' => '#4338ca', 'accent' => '#6366f1'],
        ];
    }
}
