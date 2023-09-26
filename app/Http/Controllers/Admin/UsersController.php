<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class UsersController extends Controller
{
    //
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $all_users = $this->user->withTrashed()->latest()->paginate(10);
        return view('admin.users.index')->with('all_users', $all_users);
    }

    public function deactivate($id)
    {
        $this->user->destroy($id);
        return redirect()->back();
    }

    public function activate($id)
    {
        /**
         * USERS TABLE
         * 1    (deleted_at=time)
         * 2     (deleted_at=NULL)
         * 3    (deleted_at=time)
         *
         * reference is user id =3
         * PART #1: $this->user
         * [
         *    1    (deleted_at=time)
         *    2     (deleted_at=NULL)
         *    3    (deleted_at=time)
         * ]　
         *
         * PART #2: onlyTrashed()
         * [
         *    1    (deleted_at=time)
         *    3    (deleted_at=time)
         * ]
         *
         * PART #3: ->findOrFail($id),reference is user id =3
         * [
         *    3    (deleted_at=time)
         * ]
         *
         * PART #4:->restore()
         * [
         *    3    (deleted_at=NULL)
         * ]
         */
        $this->user->onlyTrashed()->findOrFail($id)->restore();
        return redirect()->back();
    }
}
