<?php

namespace App\Models;

use App\Models\Plan;
use App\Models\Agent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use SoftDeletes;

    /**
     * All attributes are mass assignable.
     * Use with caution — this disables mass assignment protection.
     * Ensure sensitive fields are handled explicitly in controllers or services.
     */
    protected $guarded = [];

    /**
     * Get the plan associated with this order.
     *
     * Defines an inverse one-to-many relationship where
     * each order belongs to a single plan.
     *
     * @return BelongsTo
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Get the agent associated with this order.
     *
     * Defines an inverse one-to-many relationship where
     * each order belongs to a single agent.
     *
     * @return BelongsTo
     */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }
}
