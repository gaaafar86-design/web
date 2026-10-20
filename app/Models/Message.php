<?php

namespace App\Models;

use App\Models\User;
use App\Models\Agent;
use App\Models\MessageReply;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    /**
     * All attributes are mass assignable.
     * Use with caution — this disables mass assignment protection.
     * Ensure sensitive fields are handled explicitly in controllers or services.
     */
    protected $guarded = [];

    /**
     * Get the agent associated with this model.
     *
     * Defines an inverse one-to-many relationship where each message belongs to a single agent.
     *
     * @return BelongsTo
     */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }

    /**
     * Get the user associated with this model.
     *
     * Defines an inverse one-to-many relationship where each message belongs to a single agent.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all replies associated with this message.
     *
     * Defines a one-to-many relationship where a message can have multiple replies.
     *
     * @return HasMany
     */
    public function replies(): HasMany
    {
        return $this->hasMany(MessageReply::class);
    }
}
