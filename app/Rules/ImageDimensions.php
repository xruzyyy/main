<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ImageDimensions implements Rule
{
    protected $minWidth;
    protected $minHeight;
    protected $imageName;

    public function __construct($minWidth = 480, $minHeight = 480)
    {
        $this->minWidth = $minWidth;
        $this->minHeight = $minHeight;
    }

    public function passes($attribute, $value)
    {
        $image = getimagesize($value->getRealPath());
        $width = $image[0];
        $height = $image[1];
        $this->imageName = $value->getClientOriginalName();

        return $width >= $this->minWidth && $height >= $this->minHeight;
    }

    public function message()
    {
        return "The image '{$this->imageName}' must be at least {$this->minWidth}x{$this->minHeight} pixels.";
    }
}
