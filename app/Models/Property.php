<?php

namespace App\Models;

use App\Models\Agent;
use App\Models\Amenity;
use App\Models\Location;
use App\Models\PropertyType;
use App\Models\PropertyPhoto;
use App\Models\PropertyVideo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Property extends Model
{
    use SoftDeletes;

    /**
     * All attributes are mass assignable.
     * Use with caution — this disables mass assignment protection.
     * Ensure sensitive fields are handled explicitly in controllers or services.
     */
    protected $guarded = [];

    /**
     * Get the property type associated with this property.
     *
     * Defines an inverse one-to-many relationship between this model and PropertyType.
     * Each property belongs to a single property type.
     *
     * @return BelongsTo
     */
    public function propertyType(): BelongsTo
    {
        return $this->belongsTo(PropertyType::class);
    }

    /**
     * Get the location associated with this property
     *
     * Defines an inverse one-to-many relationship between this model and Location.
     * Each property belongs to a single location.
     *
     * @return BelongsTo
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get the amenities associated with this property.
     *
     * Defines a many-to-many relationship between Property and Amenity.
     * Each property can have multiple amenities, and each amenity can belong to multiple properties.
     *
     * @return BelongsToMany
     */
    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class);
    }

    /**
     * Get the photos associated with this property.
     *
     * Defines a one-to-many relationship between Property and PropertyPhoto.
     * Each property can have multiple photos stored in the property_photos table.
     *
     * @return HasMany
     */
    public function photos(): HasMany
    {
        return $this->hasMany(PropertyPhoto::class);
    }

    /**
     * Get the videos associated with this property.
     *
     * Defines a one-to-many relationship between Property and PropertyVideo.
     * Each property can have multiple videos stored in the property_videos table.
     *
     * @return HasMany
     */
    public function videos(): HasMany
    {
        return $this->hasMany(PropertyVideo::class);
    }

    /**
     * Get the agent associated with this property
     *
     * Defines an inverse one-to-many relationship between this model and Agent.
     * Each property belongs to a single agent.
     *
     * @return BelongsTo
     */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }

    /**
     * Scope a query to filter properties based on multiple optional criteria.
     *
     * This dynamic search scope applies filters conditionally based on the presence
     * of input parameters. It supports keyword matching, location and property type filtering,
     * purpose, amenities, bedroom/bathroom count, featured status, and price range.
     *
     * @param Builder $query
     * @param string|null $word
     * @param int|null $locationId
     * @param int|null $propertyTypeId
     * @param string|null $purpose
     * @param array|null $amenity
     * @param int|null $bedroom
     * @param int|null $bathroom
     * @param int|null $isFeatured
     * @param int|null $minPrice
     * @param int|null $maxPrice
     * @return void
     */
    public function scopeSearch(
        Builder $query,
        ?string $word,
        ?int $locationId,
        ?int $propertyTypeId,
        ?string $purpose,
        ?array $amenity,
        ?int $bedroom,
        ?int $bathroom,
        ?int $isFeatured,
        ?int $minPrice,
        ?int $maxPrice
    ): void
    {
        if (isset($word)) {
            $query->where('name', 'LIKE', '%' . $word . '%');
        };

        if (isset($locationId)) {
            $query->where('location_id', $locationId);
        };

        if (isset($propertyTypeId)) {
            $query->where('property_type_id', $propertyTypeId);
        };

        if (!empty($purpose)) {
            $query->where('purpose', $purpose);
        };

        if (!empty($amenity)) {
            $query->whereHas('amenities', function ($q) use ($amenity) {
                $q->whereIn('amenities.id', $amenity);
            });
        };

        if (isset($bedroom)) {
            $query->where('bedroom', $bedroom);
        };

        if (isset($bathroom)) {
            $query->where('bathroom', $bathroom);
        };

        if (isset($isFeatured)) {
            $query->where('is_featured', $isFeatured);
        };

        if (isset($minPrice)) {
            $query->where('price', '>=', $minPrice);
        };

        if (isset($maxPrice)) {
            $query->where('price', '<=', $maxPrice);
        };
    }
}
