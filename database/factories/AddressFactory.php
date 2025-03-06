<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'country' => $this->faker->country,
            'city' => $this->faker->city,
            'postal_code' => $this->faker->postcode,
            'address' => $this->faker->address,
        ];
    }
}
