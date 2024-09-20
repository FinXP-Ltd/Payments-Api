<?php

namespace App\Models\Common;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\TransactionFactory;
use App\Traits\Support\HasUuid;
use App\Traits\Support\Searchable;
use App\Traits\Support\Sortable;
use App\Traits\LocalScope\InitiatingUserTrait;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaction extends Model
{
    use HasFactory, HasUuid, Sortable, Searchable,
        InitiatingUserTrait;

    const STATUS_FAILED = 'FAILED';
    const STATUS_PENDING = 'PENDING';
    const STATUS_PROCESSING = 'PROCESSING';
    const STATUS_SUCCESS = 'SUCCESS';
    const STATUS_CANCELLED = 'CANCELLED';

    /**
     * The attributes that are not assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'amount', 'currency', 'status', 'account', 'service_id', 'transaction_date', 'transaction_time',
        'concluded_date', 'concluded_time', 'initiating_party_id', 'external_transaction_id',
        'bin', 'country', 'transaction_payment_url_id', 'reference_no', 'type', 'provider', 'initiating_receiver_id',
        'creditor_name'
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return TransactionFactory::new();
    }
}
