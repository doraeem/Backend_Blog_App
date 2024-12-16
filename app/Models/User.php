<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail; // For email verification (optional)
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // For Sanctum API authentication

class User extends Authenticatable implements MustVerifyEmail // Include MustVerifyEmail if email verification is required
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'isAdmin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Automatically hash the password
    ];

    /**
     * Set the user's password.
     *
     * If you're using an older version of Laravel without the 'hashed' cast, uncomment this.
     *
     * @param  string  $value
     * @return void
     */
    /*
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
    */

    // app/Models/User.php

  public function isAdmin()
  {
     return $this->is_admin;
   }

}
