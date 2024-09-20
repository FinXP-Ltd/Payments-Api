<?php

namespace Database\Factories;

use App\Models\Common\Merchant;
use App\Models\Common\MerchantAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class MerchantAccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MerchantAccount::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'merchant_id' => Merchant::factory()->create()->id,
            'account_number' => $this->faker->creditCardNumber(),
            'iban_number' => 'MT' . $this->faker->unique()->randomNumber,
            'account_desc' => $this->faker->company,
            'is_notification_active' => 0
        ];
    }
}
