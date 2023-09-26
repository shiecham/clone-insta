<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;



class Post extends Model
{
    use HasFactory, SoftDeletes;


    // To get the ower of the post
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    // public function categories(){
    //     return $this->hasMany(Category::class);
    // }

    // To get the categoryies under a single post
    public function categoryPost()
    {
        return $this->hasMany(CategoryPost::class);
    }

    public function category()
    {
        return $this->hasMany(Category::class);
    }

    // To get the comment of a specific post
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }
    // To get the likes of a post
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * this method will check if the login user liked a post
     * TRUE = liked
     * FALSE = if not liked
     *
     * $this->likes() = instance of the like using method likes() above
     * ->where('user_id', Auth::user()->id)   = this the condition that checks if the login user likes the post
     * ->exists()  = this make the result true or false
     *
     * LIKES TABLE entries
     * user_id = 2 (login user)
     * post_id = 5 (reference)
     *
     * result = TRUE and create red heart at post_id #5
     */

    public function isLiked()
    {
        return $this->likes()->where('user_id', Auth::user()->id)->exists();
    }
}
