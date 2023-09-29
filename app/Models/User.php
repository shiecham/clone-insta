<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // This will be used to get the posts of a single user
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // $i = CategoryPost::timestamps

    //
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // To get the all the users theat the reference user is followong　(userがfollowしている人)

    public function following()
    {
        return $this->hasMany(Follow::class, 'follower_id');
    }

    // To get the all followers of user (REFERENCE)(ユーザーのフォロワーズ)
    public function followers()
    {
        return $this->hasMany(Follow::class, 'following_id');
    }

    // This is the check if the user is being followed by the current user
    public function isFollowed()
    {
        return $this->followers()->where('follower_id', Auth::user()->id)->exists();
       
    }

    public function isFollowing()
    {
        return $this->following()->where('following_id', Auth::user()->id)->exists();
    }

}
