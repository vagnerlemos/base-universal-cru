<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $authUser): bool
    {
        return $authUser->hasPermission('users.view', 'system');
    }


    public function create(User $authUser): bool
    {
        return $authUser->hasPermission('users.create', 'system');
    }

    public function update(User $authUser, User $targetUser): bool
    {
        return $authUser->hasPermission('users.update', 'system');
    }

    public function delete(User $authUser, User $targetUser): bool
    {
        return $authUser->hasPermission('users.delete', 'system');
    }
}
