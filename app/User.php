<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $dates = ['dob'];

    protected $appends = ['name'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'str_random',
        'first_name',
        'api_token',
        'last_name',
        'password',
        'address',
        'email',
        'phone',
        'type',
    ];

    /**
     * Get the full name of the user
     * @return string Full Name for the user
     */
    public function getNameAttribute()
    {
        return mb_convert_case(
            //
            str_replace('  ', ' ', $this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name),
            //
            MB_CASE_TITLE
        );
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token',
    ];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function acceptedBookings()
    {
        return $this->hasMany(Booking::class, 'accepted');
    }
}
