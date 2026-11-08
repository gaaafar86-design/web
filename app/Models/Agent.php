<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Message;
use App\Models\Property;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Agent extends Authenticatable
{
    use SoftDeletes;

    /**
     * All attributes are mass assignable.
     * Use with caution — this disables mass assignment protection.
     * Ensure sensitive fields are handled explicitly in controllers or services.
     */
    protected $guarded = [];

    /**
     * Get all orders associated with this agent.
     *
     * Defines a one-to-many relationship where agent table
     * can have multiple related orders.
     *
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Accessor for the `status` attribute.
     *
     * Converts the raw integer value (0, 1 or 2) into a human-readable string.
     *
     * @param int $value
     * @return string
     */
    public function getStatusAttribute(int $value): string
    {
        if ($value == 0) return 'Inactive';
        if ($value == 1) return 'Active';
        if ($value == 2) return 'Suspended';
    }

    /**
     * Get all messages received by this agent.
     *
     * Defines a one-to-many relationship where an agent can have multiple associated messages.
     *
     * @return HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }


    /**
     * Get all properties associated with the agent.
     *
     * Defines a one-to-many relationship between Agent and Property.
     * Each agent can have multiple properties listed under their account.
     *
     * @return HasMany
     */
    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }
}
