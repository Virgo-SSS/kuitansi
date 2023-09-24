<?php

namespace App\Actions\User;

use App\Actions\User\Interfaces\DeleteUserActionInterface;
use App\Models\User;

class DeleteUser implements DeleteUserActionInterface
{
    public function handle(User $user): void
    {
        $user->delete();
    }
}
