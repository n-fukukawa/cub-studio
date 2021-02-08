<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthUserTest extends TestCase
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
    public function 認証中のユーザーを返す()
    {
        $response = $this->actingAs($this->user)
                         ->getJson(route('auth'));
                         
        $response->assertStatus(200)
                 ->assertJson([
                     'name' => $this->user->name
                 ]);
    }
}
