<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_register_with_valid_data(): void
    {
        $userData = [
            "name"=>"kaoutar",
            "email"=>"koko@gmail.com",
            "password"=>"123456789",
            "password_confirmation"=>"123456789",
            "role_id"=>1
        ];


        $response = $this->postJson('/api/register' , $userData);

        $response->assertStatus(200);
    }
}
