<?php

namespace App\Policies;

use App\Models\CareerPathway;
use App\Models\User;

class CareerPathwayPolicy
{
    public function view(User $user, CareerPathway $pathway): bool
    {
        return $user->id === $pathway->user_id;
    }

    public function update(User $user, CareerPathway $pathway): bool
    {
        return $user->id === $pathway->user_id;
    }

    public function delete(User $user, CareerPathway $pathway): bool
    {
        return $user->id === $pathway->user_id;
    }
}
