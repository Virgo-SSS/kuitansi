<?php

namespace App\Actions\User\Interfaces;

use App\Models\User;

interface DeleteUserActionInterface
{
    public function handle(User $user): void;
}
