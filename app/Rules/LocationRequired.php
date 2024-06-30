<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class LocationRequired implements Rule
{
    public function passes($attribute, $value)
    {
        // Check if both latitude and longitude are present and numeric
        return isset($value['latitude']) && is_numeric($value['latitude']) &&
               isset($value['longitude']) && is_numeric($value['longitude']);
    }

    public function message()
    {
        return 'The location is required ';
    }
}
