<?php

namespace App\Models;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Review;
use App\Models\Wallet;
use App\Models\Wishlist;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'avatar', 'provider_id', 'email_verified_at', 'verification_code','referral_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function wallets()
    {
        return $this->hasMany(Wallet::class)->orderBy('created_at', 'desc');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function shop()
    {
        return $this->hasOne(Shop::class,'id','shop_id');
    }

    public function followed_shops()
    {
        return $this->belongsToMany(Shop::class, 'shop_followers', 'user_id', 'shop_id');
    }

    public function chat_thread()
    {
        return $this->hasOne(ChatThread::class);
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class,'sender_id','id');
    }

    public function affiliate_user()
    {
        return $this->hasOne(AffiliateUser::class);
    }
    public function affiliate_withdraw_request()
    {
        return $this->hasMany(AffiliateWithdrawRequest::class);
    }
    public function affiliate_log()
    {
        return $this->hasMany(AffiliateLog::class);
    }

    public function delivery_boy(){
        return $this->hasOne(DeliveryBoy::class);
    }
}
