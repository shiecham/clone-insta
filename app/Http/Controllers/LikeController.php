<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    //

    private $like;

    public function __construct(Like $like)
    {
        $this->like = $like;
    }

    public function store($post_id)
    {
        $this->like->user_id = Auth::user()->id;
        $this->like->post_id = $post_id;
        $this->like->save();

        return redirect()->back();
    }

    public function destroy($post_id){
        // $this->like->destroy($post_id); This will delate all the entries in clum post_id with id with same post_id same post_id
        /**
         * LIKES TABLE
         * user_id  pos_id
         * 2        1
         * 3        2
         * 3        1
         * 4        1
         *
         */
        $this->like
            ->where('user_id',Auth::user()->id) //(3,2),(3,1)]
            ->where('post_id',$post_id) //post=1 result = [3,1]
            ->delete();

            return redirect()->back();

    }
}
