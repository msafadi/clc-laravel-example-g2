<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function cartProducts()
    {
        return $this->belongsToMany(Product::class, 'carts')
            ->using(Cart::class)
            ->withPivot(['quantity', 'price'])
            ->as('cart');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    public function hasPermission($code)
    {
        /*SELECT * FROM
roles_permissions WHERE permission = 'categories.delete'
AND role_id IN (SELECT role_id FROM users_roles WHERE user_id = 1);*/

        $count = DB::table('roles_permissions')
            ->where('permission', $code)
            ->whereRaw('role_id IN (SELECT role_id FROM users_roles WHERE user_id = ?)', [$this->id])
            ->count();

        return $count;
    }

    public function routeNotificationForMail($notification = null)
    {
        return $this->email;
    }

    public function routeNotificationForNexmo($notification = null)
    {
        return $this->mobile;
    }
}
