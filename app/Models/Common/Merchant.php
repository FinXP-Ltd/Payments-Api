<?php

namespace App\Models\Common;

use App\Traits\Merchant\HasApiKeys;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use App\Traits\Support\HasUuid;
use Database\Factories\MerchantFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Merchant extends Model
{
    use HasUuid, Notifiable, HasFactory, HasApiKeys;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const ISO = 1;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'merchants';

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);

        $this->setConnection(config('database.core_mysql'));
    }
    public function accounts(): HasMany
    {
        return $this->hasMany(MerchantAccount::class);
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
