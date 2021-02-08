<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
    }
    /**
     * @test
     * @return void
     */
    public function 新規投稿ができる()
    {
        //データを用意
        Storage::fake('public');
        $file = UploadedFile::fake()->image('test.jpg');
        $data = [
            'image'     => $file,
            'title'     => 'タイトル',
            'departure' => '出発地',
            'arrival'   => '目的地',
            'distance'  => '250',
            'time'      => '5時間30分',
            'body'      => '本文をここに入力します'
        ];
        $response = $this->actingAs($this->user)->postJson(route('post.create'), $data);

        $response->assertStatus(201);
    }

    /**
     * @test
     * @return void
     */
    public function 投稿編集ができる()
    {
        //データを用意
        $post = Post::factory()->create();
        $data = [
            'title'     => 'タイトル',
            'departure' => '出発地',
            'arrival'   => '目的地',
            'distance'  => '250',
            'time'      => '5時間30分',
            'body'      => '本文をここに入力します'
        ];
        $response = $this->actingAs($post->user)->putJson(route('post.update', $post->id), $data);
        
        $response->assertJson([
            'title' => $data['title']
        ]);
        $response->assertStatus(201);
    }

    /**
     * @test
     * @return void
     */
    // public function 投稿一覧を取得できる()
    // {
    //     //データを用意
    //     Post::factory()->count(10)->create();
    //     $posts = Post::orderBy('created_at', 'desc')->with(['user', 'likes'])->paginate(32);

    //     //リクエスト
    //     $this->assertGuest();
    //     $response = $this->getJson(route('post.index'));

    //     //検証
    //     $response->assertStatus(200)
    //              ->assertJson([
    //                  'posts'       => $posts,
    //                  'postsAmount' => $posts->count(),
    //              ]);
    // }
}
