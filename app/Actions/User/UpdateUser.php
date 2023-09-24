<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UpdateUser implements Interfaces\UpdateUserActionInterface
{
    public function handle(User $user, array $request): void
    {
        DB::transaction(function() use ($user, $request) {
            if(isset($request['password']) && $request['password'] !== null) {
                $request['password'] = Hash::make($request['password']);
            } else {
                unset($request['password']);
            }

            $user->update($request);

            $user->syncRoles($request['role']);
        });

    }
}
