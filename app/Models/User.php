<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Category;

use Illuminate\Database\Eloquent\Casts\Attribute;


class User extends Authenticatable implements MustVerifyEmail
{   
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'account_expiration_date',
        'status',
        'type',
        'image',
        'password',
    ];

     // Define a boot method to listen for updated events
     public static function boot()
     {
         parent::boot();
 
         // Listen for the updated event
         static::updated(function ($user) {
             // If the status of the user changes, update the is_active field of related categories
             if ($user->isDirty('status')) {
                 $user->categories()->update(['is_active' => $user->status]);
             }
         });
     }
 
     // Define the relationship with categories
     public function categories()
     {
         return $this->hasMany(Category::class);
     }

    // Mutator to determine if the account is active based on the expiration date
    public function getIsActiveAttribute()
    {
        return $this->attributes['account_expiration_date'] >= now();
    }
    
    protected $dates = ['account_expiration_date'];
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    // Define an accessor for the 'type' attribute
    public function getTypeAttribute($value)
    {
        $userTypes = ["user", "admin", "business"];
    
        if ($value !== null && isset($userTypes[$value])) {
            return $userTypes[$value];
        } else {
            return null;
        }
    }
    

    // Define a mutator for the 'type' attribute
public function setTypeAttribute($value)
{
    if ($value === 'business') {
        $this->attributes['type'] = 2; // Set type to 2 if the user is a business
    } else {
        $this->attributes['type'] = $value;
    }
}


    // Define a mutator for the 'status' attribute
    public function setStatusAttribute($value)
    {
        // If the user type is 'user' (0), set the status to 1
        if ($this->type == 'user') {
            $this->attributes['status'] = 1;
        } else {
            $this->attributes['status'] = $value;
        }
    }

   

}
