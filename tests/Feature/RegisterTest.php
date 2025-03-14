<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_register_with_valid_data(): void
    {

        $role = Role::factory()->create(['name'=>'admin']); 
        $userData = [
            "name"=>"kaoutar",
            "email"=>"koko@gmail.com",
            "password"=>"123456789",
            "password_confirmation"=>"123456789",
            "role_id"=>$role->id
        ];

        $response = $this->postJson('/api/register' , $userData);


        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'email' => 'koko@gmail.com'
        ]);

        $response->assertJsonStructure([
            'user' => ['id', 'name', 'email'],
            'token'
        ]);

    }

    public function test_register_with_invalid_email(): void
    {
        // $role = Role::factory()->create(['name'=>'admin']); 
      

        $userData = [
            "name" => "Kaoutar",
            "email" => "invalid-email", 
            "password" => "password123",
            "password_confirmation" => "password123",
            "role_id" => 1
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_register_with_existing_email(): void
    {
        $role = Role::factory()->create(['name'=>'admin']); 
        // $existingUser = User::factory()->create([
        //     'email' => 'kaoutar@example.com',
        //     'role_id' => $role->id
        // ]);

         $existingUser = User::factory()->create( [
            "name"=>"kaoutar",
            "email"=>"koko@gmail.com",
            "password"=>"123456789",
            "role_id"=>$role->id
        ]);



        $userData =  [
            "name"=>"kaoutar",
            "email"=>"koko@gmail.com",
            "password"=>"123456789",
            "password_confirmation"=>"123456789",
            "role_id"=>$role->id
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(422); 

        $response->assertJsonValidationErrors(['email']);
    }
}
