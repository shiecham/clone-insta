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
        /**
         * login user id = 1
         * reference id = 3
         *
         * FOLLOWS TABLE
         * follower_id     Following_id
         * 1  admin              3 john
         * 3  john              1 admin
         * 2  anne              1 admin
         * 3  john              2 anne
         *
         * $this->followers()   =   [[1,3]]
         * ->where('follower_id', Auth::user()->id)    = [[1,3]]
         * ->exists();  = TRUE
         * ============================example #2
         * login user id = 1 admin
         * reference id = 2 anne (lolling to anne's profile)
         *
         * $this->followers()   =   [[3,2]]
         * ->where('follower_id', Auth::user()->id)    = [] - empty / NULL
         * ->exists();  = FALSE
         *
         * * ============================example #3
         *
         * * login user id = 2
         * reference id = 1
         *
         * $this->followers()   =   [[3,1], [2,1]]
         * ->where('follower_id', Auth::user()->id)    = [2.1] - empty / NULL
         * ->exists();  = TRUE
         */
    }
}
