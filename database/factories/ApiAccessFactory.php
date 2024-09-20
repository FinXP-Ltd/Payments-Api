<?php

namespace Database\Factories;

use App\Models\Common\Merchant;
use App\Models\Settings\ApiAccess;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class ApiAccessFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ApiAccess::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'key' => ApiAccess::KEY_PREFIX . Str::random(33),
            'secret' => ApiAccess::SECRET_PREFIX . Str::random(33),
            'merchant_id' => Merchant::factory()->create(),
            'revoked' => false
        ];
    }
}
