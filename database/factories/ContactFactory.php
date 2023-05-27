<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ContactFactory extends Factory
{

    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        $faker = Faker::create();
        return [
            'image' => "/images/".$faker->image(public_path("images"), 120, 120, null,false),
            'name' => $this->faker->name(),
            'contact' => preg_replace('/[^0-9]/', '', $this->faker->phoneNumber()),
            'email' => $this->faker->unique()->safeEmail(),
        ];
    }
}
