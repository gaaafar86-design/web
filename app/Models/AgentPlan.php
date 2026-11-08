<?php

namespace App\Models;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgentPlan extends Model
{
    use SoftDeletes;

    /**
     * All attributes are mass assignable.
     * Use with caution — this disables mass assignment protection.
     * Ensure sensitive fields are handled explicitly in controllers or services.
     */
    protected $guarded = [];

    /**
     * Tell laravel not to fill created_at and updated_at columns.
     */
    public $timestamps = false;

    /**
     * Get the plan associated with this model.
     *
     * Defines an inverse one-to-many relationship between this model and plan.
     * Each agent-plan belongs to a single plan.
     *
     * @return BelongsTo
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }
}
