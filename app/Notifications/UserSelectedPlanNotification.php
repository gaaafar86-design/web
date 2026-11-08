<?php

namespace App\Notifications;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UserSelectedPlanNotification extends Notification
{
    use Queueable;

    public function __construct(
        public User $user,
        public Plan $plan
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'plan_selected',

            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'user_phone' => $this->user->phone,
            'user_email' => $this->user->email,

            'plan_id' => $this->plan->id,
            'plan_name' => $this->plan->name,

            'message' => 'اختار المستخدم عرضاً جديداً.',
        ];
    }
}
