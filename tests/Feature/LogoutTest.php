<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LogoutTest extends TestCase
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
    public function 認証済みのユーザーをログアウトする()
    {
        //リクエスト
        $response = $this->actingAs($this->user)->postJson(route('logout'));

        //検証
        $response->assertStatus(200);
        $this->assertGuest();
    }

    // /**
    //  * @test
    //  * @return void
    //  */
    // public function 認証済みでないユーザーはログアウトできない()
    // {
    //     //リクエスト
    //     $response = $this->postJson(route('logout'));

    //     //検証
    //     $response->assertStatus(401);
    // }
}
