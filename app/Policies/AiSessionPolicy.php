<?php

namespace App\Policies;

use App\Models\AiSession;
use App\Models\User;

class AiSessionPolicy
{
    public function view(User $user, AiSession $session): bool
    {
        return $user->id === $session->user_id;
    }

    public function update(User $user, AiSession $session): bool
    {
        return $user->id === $session->user_id;
    }

    public function delete(User $user, AiSession $session): bool
    {
        return $user->id === $session->user_id;
    }
}
