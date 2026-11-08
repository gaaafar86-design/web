<?php

namespace App\Notifications;

use App\Models\Property;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PropertyWishlisted extends Notification
{
    use Queueable;

    public function __construct(
        public User $user,
        public Property $property,
    ) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'user_phone' => $this->user->phone,
            'user_email' => $this->user->email,
            'property_id' => $this->property->id,
            'property_name' => $this->property->name,
            'property_slug' => $this->property->slug,
            'message' => $this->user->name . ' أعجبه العقار: ' . $this->property->name,
        ];
    }
}
