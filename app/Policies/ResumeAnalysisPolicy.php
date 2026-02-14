<?php

namespace App\Policies;

use App\Models\ResumeAnalysis;
use App\Models\User;

class ResumeAnalysisPolicy
{
    public function view(User $user, ResumeAnalysis $analysis): bool
    {
        return $user->id === $analysis->user_id;
    }

    public function delete(User $user, ResumeAnalysis $analysis): bool
    {
        return $user->id === $analysis->user_id;
    }
}
