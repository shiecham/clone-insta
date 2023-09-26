<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Follow extends Model
{
    use HasFactory;

    public $timestamps = false; //disable the automatic creation of Created_at and updated_at



    // To get the details of the user being followed(userがfollowしている人の詳細)
    public function following()
    {
        return $this->belongsTo(User::class,'following_id')->withTrashed();
    }

    // To get the details of the follower(userをfollowしている人の詳細)
    public function follower()
    {
        return $this->belongsTo(User::class,'follower_id')->withTrashed();
    }
}
