<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * 全投稿一覧を取得する
     * 
     * @return string JSON
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(32);

        return response()->json(['posts' => $posts, 'postsNumber' => Post::all()->count()]);
    }

    /**
     * 検索結果を取得する
     * 
     * @return string JSON
     */
    public function search(Request $request)
    {
        $posts = Post::orderBy('created_at', 'desc')->with(['user', 'likes'])->where('arrival', 'like', "%$request->search%")->paginate(32);

        return response()->json(['posts' => $posts, 'postsNumber' => $posts->count()]);
    }

    /**
     * 詳細を取得する
     * @param Post $post（投稿ID)
     * @return　JSON
     */
    public function show(Post $post){
        $post = Post::where('id', $post->id)->first();

        return response()->json([
                'post'  => $post,
                'user'  => $post->user,
                'likes' => $post->likes,
            ]);
    }

    
    /**
     * 新規投稿を保存
     * @param PostRequest $request
     */
    public function create(Request $request)
    {
        $this->validate($request, Post::$rules);
        $request->validate([
            'image' => 'required|file|mimes:jpg,jpeg,png|max:10240',
        ]);
        $post = new Post;

        $post->user_id = Auth::id();
        $post->fill($request->all());
        $post->image = Storage::disk('public')->putFile('posts', $request->file('image'));

        $post->save();

        return response()->json(['post' => $post], 201);
    }

    /**
     * 更新用のデータを取得する
     * @param Post $post（投稿ID)
     * @return　JSON
     */
    public function edit(Request $request, Post $post){
        if($request->user()->cannot('update', $post)){
            abort(403);
        }
        
        $post = Post::where('id', $post->id)->first();

        return response()->json([
                'post'  => $post,
            ]);
    }

      /**
     * 投稿を更新
     * 
     * @param PostRequest $request
     * @param Post $post ルートパラメーター (投稿ID)
     */
    public function update(Request $request, Post $post)
    {
        if($request->user()->cannot('update', $post)){
            abort(403);
        }
        //バリデーション
        $this->validate($request, Post::$rules);

        if($request->file('image')){
            $request->validate([
                'image' => 'file|mimes:jpg,jpeg,png|max:10240',
                ]);
            }

        //モデルにリクエストを保存
        $post->fill($request->all());
        
        if($request->file('image')){
            $old_image = $post->image;
            $post->image = Storage::disk('public')->putFile('posts', $request->file('image'));
            //前の画像があればを削除する
            if($old_image){
                Storage::disk('public')->delete($old_image);
            }
        }
        $post->save();

        return response()->json($post, 201);
    }

      /**
     * 投稿内容を削除
     * 
     * @param Post $post ルートパラメーター（投稿ID)
     * 
     */
    public function destroy(Request $request, Post $post)
    {
        if($request->user()->cannot('delete', $post)){
            abort(403);
        }
        //ストレージに保存してある画像ファイルを削除
        Storage::disk('public')->delete($post->image);

        return $post->delete();

    }
}
