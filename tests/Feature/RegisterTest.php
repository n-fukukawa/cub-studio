<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    /**
    * @test
     * @return void
     */
    public function 新規ユーザーを作成しユーザーデータを返す()
    {
        //データを用意
        $data = [
            'name' => 'newuser',
            'email' => 'hoge@email.com',
            'password' => 'hoge1234',
            'password_confirmation' => 'hoge1234',
        ];
        //リクエスト
        $response = $this->postJson(route('register'), $data);

        //検証
        $response->assertStatus(201)
                 ->assertJson(['name' => 'newuser']);
        $this->assertAuthenticated();

    }
}
