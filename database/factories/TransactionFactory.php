<?php

namespace Database\Factories;

use App\Models\Auth\User;
use App\Models\Common\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'account' => Str::random(10),
            'amount' => rand(1, 100),
            'currency' => 'EUR',
            'service_id' => null,
            'status' => Transaction::STATUS_PENDING,
            'transaction_date' => now()->format('Y-m-d'),
            'transaction_time' => now()->format('H:m:s'),
            'transaction_payment_url_id' => null,
            'initiating_party_id' => rand(1, 10)
        ];
    }
}
