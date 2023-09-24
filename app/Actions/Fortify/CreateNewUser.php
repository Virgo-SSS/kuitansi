<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        return DB::transaction(function () use ($input) {
            $user = User::create([
                'name' => $input['name'],
                'uuid' => $input['uuid'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]);

            $user->assignRole($input['role']);

            return $user;
        });
    }

}
