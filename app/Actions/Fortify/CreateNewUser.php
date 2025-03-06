<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Storage;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['nullable', 'string', 'max:255'],
            'profile_photo_path' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048', 'dimensions:max_width=400,max_height=400'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            'addresses.*.country' => ['required_with:addresses', 'string'],
            'addresses.*.city' => ['required_with:addresses', 'string'],
            'addresses.*.postal_code' => ['required_with:addresses', 'string'],
            'addresses.*.address' => ['required_with:addresses', 'string'],
        ])->validate();

        $photoPath = null;
        if (isset($input['photo'])) {
            $photoPath = $input['photo']->store('photos', 'public');
        }

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'phone_number' => $input['phone_number'],
            'profile_photo_path' => $photoPath,
            'password' => Hash::make($input['password']),
        ]);

        $numberAddress = count($input['country']);
        for ($i = 0; $i < $numberAddress; $i++) {
            $user->addresses()->create([
                'country' => $input['country'][$i],
                'city' => $input['city'][$i],
                'postal_code' => $input['postal_code'][$i],
                'address' => $input['address'][$i],
            ]);
        }

        return $user;
    }
}

