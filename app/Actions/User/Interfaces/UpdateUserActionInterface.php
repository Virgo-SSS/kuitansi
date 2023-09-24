<?php

namespace App\Actions\User\Interfaces;

use App\Models\User;

interface UpdateUserActionInterface
{
    public function handle(User $user, array $request): void;
}
