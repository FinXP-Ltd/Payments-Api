<?php

namespace Database\Factories;

use App\Models\Common\Merchant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class MerchantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Merchant::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'uuid' => Str::uuid()->toString(),
            'name' => $this->faker->company,
            'slug' => Str::random(16),
            'point_of_contact' => $this->faker->name,
            'street' => $this->faker->streetAddress,
            'unit_no' => $this->faker->buildingNumber,
            'city' => $this->faker->city,
            'country' => $this->faker->country,
            'postal' => $this->faker->postcode,
            'is_active' => Merchant::STATUS_ACTIVE,
            'is_iso'   => Merchant::ISO,
            'skip_computation' => false
        ];
    }
}
