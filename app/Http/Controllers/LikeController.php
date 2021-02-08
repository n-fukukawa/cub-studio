<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class LikeController extends Controller
{

    /** いいねする
    * 
    * @param Post $post ルートパラメーター（投稿ID)
    * 
    */
    public function like(Post $post)
    {
        $post->likes()->detach(Auth::id());
        $post->likes()->attach(Auth::id());

        $likesCount = $post->likes()->count();

        return response()->json(['likesCount' => $likesCount]);
    }

    /** いいねを外す
    * 
    * @param Post $post APIルートパラメーター（投稿ID)からDIにてモデルを取得
    * 
    */
    public function unlike(Post $post)
    {
        $post->likes()->detach(Auth::id());
        
        $likesCount = $post->likes()->count();
        
        return response()->json(['likesCount' => $likesCount]);
    }
}
