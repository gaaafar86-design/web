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
    use Notifiable, SoftDeletes;

    /**
     * السماح بحفظ جميع الحقول.
     */
    protected $guarded = [];

    /**
     * الحقول المخفية.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * أنواع الحقول.
     */
    protected function casts(): array
    {
        return [
            'status' => 'integer',
            'password' => 'hashed',
        ];
    }

    /**
     * الحصول على القيمة الأصلية لحالة الحساب.
     */
    public function rawStatus(): int
    {
        return (int) ($this->getRawOriginal('status') ?? 0);
    }

    /**
     * اسم حالة الحساب باللغة العربية.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->rawStatus()) {
            1 => 'مفعّل',
            2 => 'معلّق',
            default => 'غير مفعّل',
        };
    }

    /**
     * التحقق من أن الحساب مفعّل.
     */
    public function isActive(): bool
    {
        return $this->rawStatus() === 1;
    }

    /**
     * التحقق من أن الحساب غير مفعّل.
     */
    public function isInactive(): bool
    {
        return $this->rawStatus() === 0;
    }

    /**
     * التحقق من أن الحساب معلّق.
     */
    public function isSuspended(): bool
    {
        return $this->rawStatus() === 2;
    }

    /**
     * العقارات الموجودة في المفضلة.
     */
    public function wishlist(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * التحقق من وجود عقار ضمن المفضلة.
     */
    public function hasWishlisted(Property $property): bool
    {
        return $this->wishlist
            ->contains('property_id', $property->id);
    }

    /**
     * رسائل المستخدم.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
