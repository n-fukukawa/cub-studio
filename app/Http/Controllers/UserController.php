<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Rules\alpha_num_check;

class UserController extends Controller
{

    /**
     * ユーザー情報を取得する
     * @param User $user
     * @return string　Json
     */
    public function user(User $user)
    {
        $user = User::where('id', $user->id)->first();
        $user->isFollowed = $user->isFollowedBy();
        $posts = $user->posts()->orderBy('created_at', 'desc')->get();
        $likes = $user->likes()->orderBy('created_at', 'desc')->get();
        $followings = $user->followings()->orderBy('created_at', 'desc')->get();
        $followers = $user->followers()->orderBy('created_at', 'desc')->get();

        return response()->json([
                'user' => $user,
                'posts' => $posts,
                'likes' => $likes,
                'followings' => $followings,
                'followers' => $followers,
                ] );
    }

     /** 編集情報を取得する
     * @param User $user
     * @return string　Json
     */
    public function edit(Request $request, User $user)
    {
        if($user->id !== Auth::id()){
            abort(403);
        }

        $user = User::where('id', $user->id)->first();

        return response()->json([
                'user' => $user,
                ] );
    }


    /** ユーザー情報を更新する
    * 
    * @param Request $requestｓ
    * @param User $user ルートパラメーター（ユーザーID）
    * 
    */
    public function update(Request $request, User $user)
    {
        if($user->id !== Auth::id()){
            abort(403);
        }

        if($user->name !== $request->name){
            $request->validate([
                'name' => ['required', new alpha_num_check, 'unique:users', 'max:15'],
            ]);
        }
        $request->validate([
            'introduction' => 'nullable|string|max:100',
        ]);

        if($request->file('image')){
            $request->validate([
                'image' => 'file|mimes:jpg,png|max:10240',
            ]);

            Storage::disk('public')->delete($user->image);  //元の画像は削除
            $user->image = Storage::disk('public')->putFile('profiles', $request->file('image'));
        }
        
            $user->name = $request->name;
            $user->introduction = $request->introduction;
            $user->save();
    }
}