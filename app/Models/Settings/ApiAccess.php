<?php

namespace App\Models\Settings;

use App\Traits\Support\HasApiAccess;
use Database\Factories\ApiAccessFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ApiAccess extends Model
{
    use HasApiAccess, HasFactory;


    const STATUS_REVOKED = 1;
    const STATUS_ACTIVE = 0;

    CONST KEY_PREFIX = 'ap_';
    const SECRET_PREFIX = 'sk_';

    protected $table = 'api_access';

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);

        $this->setConnection(config('database.core_mysql'));
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description', 'key', 'secret', 'merchant_id', 'revoked'
    ];

    /**
     * The attributes that are not assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    /**
     * Fields that should be casts to another type
     *
     * @var array
     */
    protected $casts = [
        'revoked' => 'boolean'
    ];

    protected $appends = ['sandbox_mode'];

    public function revokeToken(): void
    {
        $this->update([
            'revoked' => true
        ]);
    }

    public function merchant(): BelongsTo
    {
        if (Str::contains($this->getConnection()->getName(), ['sandbox'])) {
            return $this->setConnection(config('database.default'))
                ->belongsTo('App\Models\Common\Merchant');
        }

        return $this->belongsTo('App\Models\Common\Merchant');
    }

    public function getSandboxModeAttribute($value) {
        return $value;
    }
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return ApiAccessFactory::new();
    }
}
