<?php

namespace App\Models;

use App\Models\Message;
use App\Models\Property;
use App\Models\Wishlist;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use Notifiable, SoftDeletes;

    /**
     * All attributes are mass assignable.
     * Use with caution — this disables mass assignment protection.
     * Ensure sensitive fields are handled explicitly in controllers or services.
     */
    protected $guarded = [];

    /**
     * Attributes hidden from array and JSON serialization.
     * Prevents exposure of sensitive fields.
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
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
     * Get all wishlist entries associated with this user.
     *
     * Defines a one-to-many relationship where a user can have multiple wishlist items.
     * Each wishlist entry typically references a property the user has favorited.
     *
     * @return HasMany
     */
    public function wishlist(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Determine if the authenticated user has wishlisted the given property.
     *
     * Checks the user's wishlist collection to see if it contains an entry
     * matching the specified property's ID. Returns `true` if found, otherwise `false`.
     *
     * @param Property $property
     * @return bool
     */
    public function hasWishlisted(Property $property): bool
    {
        return $this->wishlist->contains('property_id', $property->id);
    }

    /**
     * Get all messages sent or received by this user.
     *
     * Defines a one-to-many relationship where a user can have multiple associated messages.
     *
     * @return HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
