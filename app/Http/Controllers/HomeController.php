<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class HomeController extends Controller
{
    private $post;
    private $user;

    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }

    // get the user that the auth user is not following
    private function getSuggestedUsers()
    {
        $all_users = $this->user->all()->except(Auth::user()->id);
        $suggested_users = [];

        foreach ($all_users as $user) {
            if (!$user->isFollowed()) {
                $suggested_users[] = $user;
            }
        }
        /**
         * INITIAL STATE
         * $all_user
         * USERS TABLE
         * 1 (ligin user) (EXCEPT)->except(Auth::user()->id);
         * 2
         * 3
         *
         * FOLLOWS TABLE
         * follower_id    |   following_id
         *    1                    2
         *    2                    3
         *    2                    1
         *
         * $suggested_user = [];
         *
         * LOOP
         * ITR #1 user 2
         * CONDITION = if(!user->isFollowed())
         * RESULT = !TURE = FALSE
         * $suggested_user = []
         *
         *
         * ITR #2 user 3
         *CONDITION = if(!user->isFollowed())
         * RESULT = !FALSE = TRUE
         * $suggested_user = [3]
         *
         */

        return array_slice($suggested_users, 0, 10);
    }

    private function getHomePosts()
    {
        $all_posts = $this->post->latest()->get();
        $home_posts = [];
        /**
         * LOGICAL OR OPERATOR
         * T || T = T
         * F || T = T
         * T || F = T
         * F || F = F
         *
         * ALL_POST ID's
         * 1 = own by loginuser id=1
         * 2 = user id 3
         * 3 = own by user id =1
         * 4 = own by user 2 followed by user 1
         */
        foreach ($all_posts as $post) {
            if ($post->user->isFollowed() || $post->user->id === Auth::user()->id) {
                $home_posts[] = $post;
                /**
                 * ITR 1:
                 *  f || t = t
                 *  $home_posts= [1]
                 * ITR 2:
                 *  f || f = f (SKIP  IF  CONDITTION)
                 *  $home_posts= [1]
                 * ITR 3:
                 *  f || t = t
                 *  $home_posts= [1] ->[3] = [1,3]
                 * ITR 3:
                 *  t || f = t
                 *  $home_posts= [1,3] -> [4] = [1,3,4]
                 */
            }
        }
        return $home_posts;
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $all_posts = $this->post->latest()->get();
        $all_posts = $this->getHomePosts();
        $suggested_users = $this->getSuggestedUsers();


        return view('users.home')
            ->with('all_posts', $all_posts)
            ->with('suggested_users', $suggested_users);
    }
}
