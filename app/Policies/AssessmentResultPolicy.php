<?php

namespace App\Policies;

use App\Models\AssessmentResult;
use App\Models\User;

class AssessmentResultPolicy
{
    public function view(User $user, AssessmentResult $result): bool
    {
        return $user->id === $result->user_id;
    }

    public function delete(User $user, AssessmentResult $result): bool
    {
        return $user->id === $result->user_id;
    }
}
