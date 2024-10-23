<?php

namespace App\Actions\Fortify;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'role' => ['required', Rule::in(['admin', 'wisata','kuliner','akomodasi','ekraf','guide'])], // Ganti dengan peran yang Anda inginkan
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    
        $role = Role::where('name', $input['role'])->first();
    
        // Save the user's role with the corresponding guard_name
        // $user->roles()->attach($role, ['guard_name' => 'web']); // Replace 'web' with the desired guard_name
        $user->roles()->attach($role);
        return $user;
    }
}