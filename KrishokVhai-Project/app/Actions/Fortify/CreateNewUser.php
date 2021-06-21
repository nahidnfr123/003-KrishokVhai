<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Rules\NameStringValidateRule;
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
     * @param array $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        $user_type = $input['user_type'];
        Validator::make($input, [
            'user_type' => ['required', 'string'],
            'first_name' => ['required', 'string', 'min:3', 'max:30', new NameStringValidateRule()],
            'last_name' => ['required', 'string', 'min:3', 'max:30', new NameStringValidateRule()],
            'email' => ['required', 'string', 'email', 'max:80', Rule::unique(User::class),],
            'username' => ['required', 'string', 'max:20', 'min:3', Rule::unique(User::class),],
            'postal_code' => ['required_if:user_type,!=,customer', 'numeric', 'regex:/[0-9]{4,5}/'],
            'mobile_number' => ['required', 'numeric', 'digits:11', 'regex:/(01)[0-9]{9}/', Rule::unique(User::class),],
            'password' => $this->passwordRules(),
        ])->validate();

        $user = new User();
        $user->first_name = ucfirst($input['first_name']);
        $user->last_name = ucfirst($input['last_name']);
        $user->username = $input['username'];
        $user->mobile_number = $input['mobile_number'];
        $user->postal_code = $input['postal_code'];
        $user->email = $input['email'];
        $user->password = Hash::make($input['password']);
        if ($user_type == 'agricultural-officer') {
            $user->status = 'pending';
        }
        $user->save();

        $user->assignRole($user_type);
        return $user;
    }
}
