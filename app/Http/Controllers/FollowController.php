<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class FollowController extends Controller
{

    /** フォローする
    * 
    * @param User $user ルートパラメーター（ユーザーID)
    * 
    */
    public function follow(User $user)
    {
        $user->followers()->detach(Auth::id());
        $user->followers()->attach(Auth::id());
    }


    /** フォローを解除する
    * 
    * @param User $user ルートパラメーター
    * 
    */
    public function unfollow(User $user)
    {
        $user->followers()->detach(Auth::id());
    }

}
