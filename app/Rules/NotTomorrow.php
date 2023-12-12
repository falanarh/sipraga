<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class NotTomorrow implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Check if the selected date is not tomorrow or a future date
        return Carbon::parse($value)->isBefore(Carbon::now()->addDay());
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    
    public function message()
    {
        return 'Tanggal harus hari masa lalu atau hari ini!';
    }
}
