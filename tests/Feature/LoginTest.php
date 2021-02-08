<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // 登録済みのユーザーを用意
        $this->user = User::factory()->create();
    }

    /**
     * @test
     * @return void
     */
    public function 登録済みのユーザーを認証しユーザーデータを返す()
    {
        //データを用意
        $data = [
            'email'     => $this->user->email,
            'password'  => 'password',
        ];

        //リクエスト
        $response = $this->postJson(route('login'), $data);

        //検証
        $response->assertStatus(200)
                 ->assertJson(['name' => $this->user->name]);
        $this->assertAuthenticated();
    }

     /**
     * @test
     * @return void
     */
    public function パスワードを間違えるとログインできない()
    {
        //データを用意
        $data = [
            'email'     => $this->user->email,
            'password'  => 'passWord',
        ];

        //リクエスト
        $response = $this->postJson(route('login'), $data);

        //検証
        $response->assertStatus(422);
        $this->assertGuest();
    }

    // /**
    //  * @test
    //  * @return void
    //  */
    // public function 認証済みのユーザーはリダイレクトされる()
    // {
    //     //データを用意
    //     $data = [
    //         'email'     => $this->user->email,
    //         'password'  => 'password',
    //     ];

    //     //リクエスト
    //     $response = $this->actingAs($this->user)->postJson(route('login'), $data);

    //     //検証
    //     $response->assertStatus(302);
    // }
}
