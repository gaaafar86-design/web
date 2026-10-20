<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhyChooseUs extends Model
{
    /**
     * All attributes are mass assignable.
     * Use with caution — this disables mass assignment protection.
     * Ensure sensitive fields are handled explicitly in controllers or services.
     */
    protected $guarded = [];

    /**
     * Name of the table in database.
     */
    protected $table = 'why_choose_us';
}
