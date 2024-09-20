<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;
use Database\Factories\MerchantFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MerchantAccount extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'merchant_accounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'merchant_id', 'account_number', 'iban_number', 'account_desc', 'is_notification_active'
    ];


    public function __construct($attributes = [])
    {
        parent::__construct($attributes);

        $this->setConnection(config('database.core_mysql'));
    }

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(
            Merchant::class,
            'merchant_id'
        );
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return MerchantFactory::new();
    }
}
